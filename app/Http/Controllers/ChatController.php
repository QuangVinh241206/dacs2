<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
	/**
	 * Query products based on user message and return suggestions.
	 * Uses Google Gemini API key (GOOGLE_GEMINI_API_KEY) or falls back to OpenAI.
	 */
	public function query(Request $request)
	{
		$request->validate(["message" => "required|string|max:1000"]);

		$message = $request->input('message');

		// Basic keyword search: split words and search name/description
		$words = preg_split('/\s+/', trim($message));

		$productsQuery = Product::query();
		$productsQuery->where(function($q) use ($words) {
			foreach ($words as $word) {
				$w = trim($word);
				if ($w === '') continue;
				$q->orWhere('name', 'like', "%$w%")
				  ->orWhere('description', 'like', "%$w%");
			}
		});

		$products = $productsQuery->with('images')->limit(8)->get();

		$result = $products->map(function($p) {
			$mainImage = $p->images->first();
			$thumbnail = null;
			if ($mainImage) {
				$path = $mainImage->image_url;
				if (preg_match('#^https?://#', $path)) {
					$thumbnail = $path;
				} else {
					if (Storage::exists($path)) {
						$thumbnail = Storage::url($path);
					} else {
						$thumbnail = asset($path);
					}
				}
			}

			return [
				'id' => $p->id,
				'name' => $p->name,
				'slug' => $p->slug,
				'price' => $p->price ?? null,
				'thumbnail' => $thumbnail,
				'short_description' => strlen($p->description) > 120 ? substr($p->description, 0, 117) . '...' : $p->description,
			];
		});

		$count = $result->count();

		// Build prompt products (limit) and system prompt for structured JSON output
		$productsForPrompt = $result->take(5)->map(function($p) {
			return [
				'id' => $p['id'] ?? null,
				'name' => $p['name'],
				'slug' => $p['slug'],
				'price' => $p['price'],
				'thumbnail' => $p['thumbnail'],
				'short_description' => mb_strimwidth($p['short_description'], 0, 240, '...'),
			];
		})->toArray();

		$system = "Bạn là một trợ lý bán hàng cho cửa hàng nội thất. Trả lời ngắn gọn, lịch sự bằng tiếng Việt. Khi trả lời, CHỈ xuất ra một JSON hợp lệ duy nhất theo định dạng sau (không thêm văn bản khác):\n{\n  \"message\": \"<tóm tắt trả lời bằng tiếng Việt>\",\n  \"suggestions\": [\n    {\n      \"id\": <id nếu có hoặc null>,\n      \"name\": \"<tên sản phẩm>\",\n      \"slug\": \"<slug>\",\n      \"price\": \"<giá hoặc null>\",\n      \"thumbnail\": \"<thumbnail url hoặc null>\",\n      \"reason\": \"<lý do tại sao sản phẩm phù hợp>\"\n    }, ...\n  ]\n}\nNếu không có sản phẩm phù hợp, trả {\"message\": \"<gợi ý hỏi thêm>\", \"suggestions\": []}.\nLuôn trả JSON hợp lệ.";

		$promptProducts = json_encode($productsForPrompt, JSON_UNESCAPED_UNICODE);

		$aiReply = null;

		// Try Google Gemini API with direct API key
		$geminiKey = env('GOOGLE_GEMINI_API_KEY');
		if ($geminiKey) {
			try {
				$model = env('GOOGLE_GENAI_MODEL', 'text-bison-001');
				$url = "https://generativelanguage.googleapis.com/v1beta2/models/{$model}:generate?key=" . urlencode($geminiKey);

				$fullPrompt = $system . "\nAvailable products (JSON):\n" . $promptProducts . "\nUser: " . $message;

				$resp = Http::timeout(10)->acceptJson()
					->post($url, [
						'prompt' => ['text' => $fullPrompt],
						'temperature' => 0.2,
						'maxOutputTokens' => 512,
					]);

				if ($resp->successful()) {
					$body = $resp->json();
					if (isset($body['candidates'][0]['output'])) {
						$aiReply = $body['candidates'][0]['output'];
					} elseif (isset($body['candidates'][0]['content'])) {
						$aiReply = $body['candidates'][0]['content'];
					}
				} else {
					Log::warning('Google Generative API failed', ['status' => $resp->status(), 'body' => $resp->body()]);
				}
			} catch (\Exception $e) {
				Log::error('Generative API call error: ' . $e->getMessage());
			}
		}

		// If no aiReply yet, fall back to OpenAI key (if present)
		if (!$aiReply) {
			$openaiKey = config('services.openai.key') ?: env('OPENAI_API_KEY');
			if ($openaiKey && !preg_match('/^AIza/', $openaiKey)) {
				try {
					$messages = [
						['role' => 'system', 'content' => $system],
						['role' => 'system', 'content' => "Available products (JSON):\n" . $promptProducts],
						['role' => 'user', 'content' => $message],
					];

					$resp = Http::withToken($openaiKey)
						->acceptJson()
						->post('https://api.openai.com/v1/chat/completions', [
							'model' => 'gpt-3.5-turbo',
							'messages' => $messages,
							'temperature' => 0.2,
							'max_tokens' => 400,
						]);

					if ($resp->successful()) {
						$body = $resp->json();
						if (isset($body['choices'][0]['message']['content'])) {
							$aiReply = $body['choices'][0]['message']['content'];
						}
					} else {
						Log::warning('OpenAI response not successful', ['status' => $resp->status(), 'body' => $resp->body()]);
					}
				} catch (\Exception $e) {
					Log::error('OpenAI call error: ' . $e->getMessage());
				}
			}
		}

		// Try to parse AI reply as JSON according to the schema we asked for.
		$suggestions = [];
		if ($aiReply) {
			$decoded = json_decode($aiReply, true);
			if ($decoded === null) {
				if (preg_match('/\{.*\}/s', $aiReply, $m)) {
					$maybe = $m[0];
					$decoded = json_decode($maybe, true);
				}
			}

			if (is_array($decoded) && isset($decoded['message']) && isset($decoded['suggestions'])) {
				$aiReply = $decoded['message'];
				foreach ($decoded['suggestions'] as $s) {
					$suggestions[] = [
						'id' => $s['id'] ?? null,
						'name' => $s['name'] ?? ($s['title'] ?? null),
						'slug' => $s['slug'] ?? null,
						'price' => $s['price'] ?? null,
						'thumbnail' => $s['thumbnail'] ?? null,
						'reason' => $s['reason'] ?? null,
					];
				}
			}
		}

		if (empty($suggestions)) {
			if ($count === 0) {
				$aiReply = 'Mình hiện không tìm thấy sản phẩm phù hợp, bạn có thể mô tả rõ hơn (kích thước, chất liệu, màu, khoảng giá) để mình tìm giúp.';
			} else {
				$aiReply = $aiReply ?? ('Mình tìm thấy ' . $count . ' sản phẩm phù hợp. Dưới đây là một vài gợi ý cho bạn.');
			}

			foreach ($result as $p) {
				$suggestions[] = [
					'id' => $p['id'] ?? null,
					'name' => $p['name'] ?? null,
					'slug' => $p['slug'] ?? null,
					'price' => $p['price'] ?? null,
					'thumbnail' => $p['thumbnail'] ?? null,
					'reason' => 'Sản phẩm phù hợp với yêu cầu của bạn',
				];
			}
		}

		return response()->json([
			'reply' => $aiReply,
			'products' => $suggestions,
		]);
	}

}


