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

		// Parse price constraints from message
		$maxPrice = null;
		$minPrice = null;

		// Parse size, color, material constraints
		$size = null;
		$color = null;
		$material = null;

		// Look for price patterns like "dưới 5 triệu", "trên 2tr", "giá từ 1-3 triệu", etc.
		if (preg_match('/(?:dưới|duoi|nhỏ hơn|it hơn|<=|<)\s*(\d+(?:\.\d+)?)\s*(triệu|tr|nghìn|nghin|k)/i', $message, $matches)) {
			$amount = (float) $matches[1];
			$unit = strtolower($matches[2]);
			if ($unit === 'triệu' || $unit === 'tr') {
				$maxPrice = $amount * 1000000;
			} elseif ($unit === 'nghìn' || $unit === 'nghin' || $unit === 'k') {
				$maxPrice = $amount * 1000;
			}
		}

		if (preg_match('/(?:trên|tren|lớn hơn|nhiều hơn|>=|>)\s*(\d+(?:\.\d+)?)\s*(triệu|tr|nghìn|nghin|k)/i', $message, $matches)) {
			$amount = (float) $matches[1];
			$unit = strtolower($matches[2]);
			if ($unit === 'triệu' || $unit === 'tr') {
				$minPrice = $amount * 1000000;
			} elseif ($unit === 'nghìn' || $unit === 'nghin' || $unit === 'k') {
				$minPrice = $amount * 1000;
			}
		}

		// Handle range patterns: "từ 1-8 triệu", "giá từ 1 đến 8 triệu", "1-8 triệu", etc.
		if (preg_match('/(?:giá\s+)?(?:từ|tu|giữa|between)?\s*(\d+(?:\.\d+)?)\s*[-]\s*(\d+(?:\.\d+)?)\s*(triệu|tr|nghìn|nghin|k)/i', $message, $matches)) {
			$minAmount = (float) $matches[1];
			$maxAmount = (float) $matches[2];
			$unit = strtolower($matches[3]);
			if ($unit === 'triệu' || $unit === 'tr') {
				$minPrice = $minAmount * 1000000;
				$maxPrice = $maxAmount * 1000000;
			} elseif ($unit === 'nghìn' || $unit === 'nghin' || $unit === 'k') {
				$minPrice = $minAmount * 1000;
				$maxPrice = $maxAmount * 1000;
			}
		}

		if (preg_match('/(?:giá\s+)?(?:từ|tu|giữa|between)\s*(\d+(?:\.\d+)?)\s*(?:-|đến|den|to)\s*(\d+(?:\.\d+)?)\s*(triệu|tr|nghìn|nghin|k)/i', $message, $matches)) {
			$minAmount = (float) $matches[1];
			$maxAmount = (float) $matches[2];
			$unit = strtolower($matches[3]);
			if ($unit === 'triệu' || $unit === 'tr') {
				$minPrice = $minAmount * 1000000;
				$maxPrice = $maxAmount * 1000000;
			} elseif ($unit === 'nghìn' || $unit === 'nghin' || $unit === 'k') {
				$minPrice = $minAmount * 1000;
				$maxPrice = $maxAmount * 1000;
			}
		}

		// Parse size patterns: "size S", "kích thước M", "cỡ L", etc.
		if (preg_match('/(?:size|kích thước|cỡ|kích cỡ)\s*([A-Z0-9]+)/i', $message, $matches)) {
			$size = strtoupper($matches[1]);
		}

		// Parse color patterns: "màu đỏ", "color blue", "màu xanh", etc.
		if (preg_match('/(?:màu|mau|color)\s+([^\s,]+)/i', $message, $matches)) {
			$color = $matches[1];
		}

		// Parse material patterns: "chất liệu gỗ", "material plastic", "vải", etc.
		if (preg_match('/(?:chất liệu|chat lieu|material)\s+([^\s,]+)/i', $message, $matches)) {
			$material = $matches[1];
		}
		if (preg_match('/(?:dưới|duoi|nhỏ hơn|it hơn|<=|<)\s*(\d+(?:\.\d+)?)\s*(triệu|tr|nghìn|nghin|k)/i', $message, $matches)) {
			$amount = (float) $matches[1];
			$unit = strtolower($matches[2]);
			if ($unit === 'triệu' || $unit === 'tr') {
				$maxPrice = $amount * 1000000;
			} elseif ($unit === 'nghìn' || $unit === 'nghin' || $unit === 'k') {
				$maxPrice = $amount * 1000;
			}
		}

		if (preg_match('/(?:trên|tren|lớn hơn|nhiều hơn|>=|>)\s*(\d+(?:\.\d+)?)\s*(triệu|tr|nghìn|nghin|k)/i', $message, $matches)) {
			$amount = (float) $matches[1];
			$unit = strtolower($matches[2]);
			if ($unit === 'triệu' || $unit === 'tr') {
				$minPrice = $amount * 1000000;
			} elseif ($unit === 'nghìn' || $unit === 'nghin' || $unit === 'k') {
				$minPrice = $amount * 1000;
			}
		}

		// Handle range patterns: "từ 1-8 triệu", "giá từ 1 đến 8 triệu", "1-8 triệu", etc.
		if (preg_match('/(?:giá\s+)?(?:từ|tu|giữa|between)?\s*(\d+(?:\.\d+)?)\s*[-]\s*(\d+(?:\.\d+)?)\s*(triệu|tr|nghìn|nghin|k)/i', $message, $matches)) {
			$minAmount = (float) $matches[1];
			$maxAmount = (float) $matches[2];
			$unit = strtolower($matches[3]);
			if ($unit === 'triệu' || $unit === 'tr') {
				$minPrice = $minAmount * 1000000;
				$maxPrice = $maxAmount * 1000000;
			} elseif ($unit === 'nghìn' || $unit === 'nghin' || $unit === 'k') {
				$minPrice = $minAmount * 1000;
				$maxPrice = $maxAmount * 1000;
			}
		}

		if (preg_match('/(?:giá\s+)?(?:từ|tu|giữa|between)\s*(\d+(?:\.\d+)?)\s*(?:-|đến|den|to)\s*(\d+(?:\.\d+)?)\s*(triệu|tr|nghìn|nghin|k)/i', $message, $matches)) {
			$minAmount = (float) $matches[1];
			$maxAmount = (float) $matches[2];
			$unit = strtolower($matches[3]);
			if ($unit === 'triệu' || $unit === 'tr') {
				$minPrice = $minAmount * 1000000;
				$maxPrice = $maxAmount * 1000000;
			} elseif ($unit === 'nghìn' || $unit === 'nghin' || $unit === 'k') {
				$minPrice = $minAmount * 1000;
				$maxPrice = $maxAmount * 1000;
			}
		}

		// Basic keyword search: split words and search name/description
		$words = preg_split('/\s+/', trim($message));

		$productsQuery = Product::query();
		$productsQuery->where(function ($q) use ($words) {
			foreach ($words as $word) {
				$w = trim($word);
				if ($w === '')
					continue;
				// Skip price-related words and numbers, and attribute words
				if (preg_match('/^(dưới|duoi|trên|tren|từ|tu|giá|gia|giữa|between|triệu|tr|nghìn|nghin|k|đến|den|to|size|kích thước|cỡ|kích cỡ|màu|mau|color|chất liệu|chat lieu|material|\d+)$/i', $w))
					continue;
				$q->orWhere('name', 'like', "%$w%")
					->orWhere('description', 'like', "%$w%");
			}
		});

		// Apply filters
		if ($material !== null) {
			$productsQuery->where('material', 'like', "%$material%");
		}

		if ($size !== null || $color !== null || $minPrice !== null || $maxPrice !== null) {
			$productsQuery->whereHas('variants', function ($q) use ($size, $color, $minPrice, $maxPrice) {
				if ($size !== null) {
					$q->where('size', 'like', "%$size%");
				}
				if ($color !== null) {
					$q->where('color', 'like', "%$color%");
				}
				if ($minPrice !== null) {
					$q->where('price', '>=', $minPrice);
				}
				if ($maxPrice !== null) {
					$q->where('price', '<=', $maxPrice);
				}
			});
		}

		$products = $productsQuery->with('images', 'variants')->limit(8)->get();

		$result = $products->map(function ($p) {
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

			// Get price from variants (minimum price if multiple variants)
			$price = null;
			if ($p->variants && $p->variants->count() > 0) {
				$price = $p->variants->min('price');
			}

			return [
				'id' => $p->id,
				'name' => $p->name,
				'slug' => $p->slug,
				'price' => $price,
				'thumbnail' => $thumbnail,
				'short_description' => strlen($p->description) > 120 ? substr($p->description, 0, 117) . '...' : $p->description,
			];
		});

		$count = $result->count();

		// Build prompt products (limit) and system prompt for structured JSON output
		$productsForPrompt = $result->take(5)->map(function ($p) {
			return [
				'id' => $p['id'] ?? null,
				'name' => $p['name'],
				'slug' => $p['slug'],
				'price' => $p['price'],
				'thumbnail' => $p['thumbnail'],
				'short_description' => mb_strimwidth($p['short_description'], 0, 240, '...'),
			];
		})->toArray();

		$system = "Bạn là một trợ lý bán hàng cho cửa hàng nội thất. Trả lời ngắn gọn, lịch sự bằng tiếng Việt. Khi trả lời, CHỈ xuất ra một JSON hợp lệ duy nhất theo định dạng sau (không thêm văn bản khác):\n{\n  \"message\": \"<tóm tắt trả lời bằng tiếng Việt>\",\n  \"suggestions\": [\n    {\n      \"id\": <id nếu có hoặc null>,\n      \"name\": \"<tên sản phẩm>\",\n      \"slug\": \"<slug>\",\n      \"price\": \"<giá hoặc null>\",\n      \"thumbnail\": \"<thumbnail url hoặc null>\",\n      \"reason\": \"<lý do tại sao sản phẩm phù hợp>\"\n    }, ...\n  ]\n}\nNếu không có sản phẩm phù hợp, trả {\"message\": \"<gợi ý hỏi thêm>\", \"suggestions\": []}.\nLuôn trả JSON hợp lệ. Lưu ý: Giá sản phẩm được hiển thị theo định dạng tiền tệ Việt Nam (VNĐ). Bạn có thể tìm sản phẩm theo kích thước (size), màu sắc (color), chất liệu (material) và khoảng giá.";

		$promptProducts = json_encode($productsForPrompt, JSON_UNESCAPED_UNICODE);

		// Add filter info to prompt
		$filterInfo = "";
		$filters = [];
		if ($minPrice !== null || $maxPrice !== null) {
			$priceText = "";
			if ($minPrice !== null) {
				$priceText .= "từ " . number_format($minPrice) . " VNĐ ";
			}
			if ($maxPrice !== null) {
				$priceText .= ($minPrice !== null ? "đến " : "") . number_format($maxPrice) . " VNĐ";
			}
			$filters[] = "giá: " . $priceText;
		}
		if ($size !== null) {
			$filters[] = "kích thước: " . $size;
		}
		if ($color !== null) {
			$filters[] = "màu: " . $color;
		}
		if ($material !== null) {
			$filters[] = "chất liệu: " . $material;
		}
		if (!empty($filters)) {
			$filterInfo = "\nĐã lọc sản phẩm theo: " . implode(", ", $filters);
		}

		$aiReply = null;

		// Try Google Gemini API with direct API key
		$geminiKey = env('GOOGLE_GEMINI_API_KEY');
		if ($geminiKey) {
			try {
				$model = env('GOOGLE_GENAI_MODEL', 'text-bison-001');
				$url = "https://generativelanguage.googleapis.com/v1beta2/models/{$model}:generate?key=" . urlencode($geminiKey);

				$fullPrompt = $system . "\nAvailable products (JSON):\n" . $promptProducts . $filterInfo . "\nUser: " . $message;

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
						['role' => 'system', 'content' => "Available products (JSON):\n" . $promptProducts . $filterInfo],
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
				if ($minPrice !== null || $maxPrice !== null) {
					$priceRange = "";
					if ($minPrice !== null && $maxPrice !== null) {
						$priceRange = "trong khoảng " . number_format($minPrice) . " - " . number_format($maxPrice) . " VNĐ";
					} elseif ($minPrice !== null) {
						$priceRange = "từ " . number_format($minPrice) . " VNĐ trở lên";
					} elseif ($maxPrice !== null) {
						$priceRange = "dưới " . number_format($maxPrice) . " VNĐ";
					}
					$aiReply = 'Mình hiện không tìm thấy sản phẩm nào ' . $priceRange . '. Bạn có thể thử tìm kiếm với khoảng giá khác hoặc mô tả sản phẩm cụ thể hơn.';
				} else {
					$aiReply = 'Mình hiện không tìm thấy sản phẩm phù hợp, bạn có thể mô tả rõ hơn (kích thước, chất liệu, màu, khoảng giá) để mình tìm giúp.';
				}
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


