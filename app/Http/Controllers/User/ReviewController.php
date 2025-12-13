<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'nullable|integer|exists:orders,id',
            'product_id' => 'required|integer|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!empty($data['order_id'])) {
            $order = Order::with('details')
                ->where('id', $data['order_id'])
                ->where('user_id', Auth::id())
                ->first();

            if (!$order) {
                return redirect()->back()->with('error', 'Không tìm thấy đơn hàng.');
            }

            if ($order->order_status !== 'completed') {
                return redirect()->back()->with('error', 'Chỉ có thể đánh giá khi đơn hàng đã hoàn thành.');
            }

            $belongsToOrder = $order->details->contains(function ($d) use ($data) {
                return (int) $d->product_id === (int) $data['product_id'];
            });

            if (!$belongsToOrder) {
                return redirect()->back()->with('error', 'Sản phẩm không thuộc đơn hàng này.');
            }
        }

        $product = Product::findOrFail($data['product_id']);

        // Create or update user's review for the product
        $review = Review::updateOrCreate(
            ['product_id' => $product->id, 'user_id' => Auth::id()],
            ['rating' => $data['rating'], 'comment' => $data['comment'] ?? '']
        );

        // reload product reviews
        $product->load('reviews.user');

        if ($request->expectsJson()) {
            $reviewsHtml = view('user.partials.reviews_list', ['reviews' => $product->reviews])->render();
            $avg = $product->reviews->avg('rating') ?? 0;
            $count = $product->reviews->count();
            return response()->json(['html' => $reviewsHtml, 'avg' => (float) $avg, 'count' => $count]);
        }

        return redirect()->back()->with('success', 'Cảm ơn bạn đã gửi đánh giá.');
    }
}
