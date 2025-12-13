<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\Cart;
use App\Models\CartDetail;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Add item to session-based cart
    public function add(Request $request)
    {
        Log::info('Cart add called', ['ip' => $request->ip(), 'payload' => $request->all()]);
        try {
            $data = $request->validate([
                'variant_id' => 'required',
                'quantity' => 'required|integer|min:1',
                'product_id' => 'nullable|integer',
                'buy_now' => 'sometimes|boolean',
            ]);
        } catch (ValidationException $e) {
            Log::warning('Cart add validation failed', ['errors' => $e->errors()]);
            return response()->json(['success' => false, 'message' => 'Dữ liệu không hợp lệ', 'errors' => $e->errors()], 422);
        }

        $variantId = (int) $data['variant_id'];
        $qty = (int) $data['quantity'];

        // If user is authenticated, persist to DB
        if (Auth::check()) {
            $user = Auth::user();
            $cartModel = $user->cart;
            if (!$cartModel) {
                $cartModel = Cart::create(['user_id' => $user->id]);
            }

            // Try to find existing cart detail by variant (strict integer comparison)
            $detail = CartDetail::where('cart_id', $cartModel->id)
                ->where('variant_id', $variantId)
                ->first();

            if ($detail) {
                Log::info('Existing cart detail found - incrementing quantity', ['cart_detail_id' => $detail->id, 'existing_variant' => $detail->variant_id, 'incoming_variant' => $variantId, 'increment' => $qty]);
                $detail->quantity += $qty;
                $detail->save();
                $detailVariant = $detail->variant_id;
                $detailId = $detail->id;
            } else {
                $new = CartDetail::create([
                    'cart_id' => $cartModel->id,
                    'product_id' => $data['product_id'] ?? null,
                    'variant_id' => $variantId,
                    'quantity' => $qty,
                ]);
                Log::info('Created new cart detail', ['cart_detail_id' => $new->id, 'variant' => $new->variant_id]);
                $detailVariant = $new->variant_id;
                $detailId = $new->id;
            }

            $count = (int) $cartModel->items()->sum('quantity');

            Log::info('Cart DB updated', ['user_id' => $user->id, 'cart_id' => $cartModel->id, 'count' => $count]);

            if ($request->boolean('buy_now')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đã thêm vào giỏ hàng',
                    'count' => $count,
                    'detail_variant' => $detailVariant,
                    'redirect_url' => route('user.cart.index', ['select' => $detailId]),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Đã thêm vào giỏ hàng',
                'count' => $count,
                'detail_variant' => $detailVariant,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Vui lòng đăng nhập để thêm vào giỏ hàng.',
        ], 401);

    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login')->with('error', 'Vui lòng đăng nhập để xem giỏ hàng.');
        }

        $cart = Auth::user()->cart;
        $items = $cart ? $cart->items()->with('product', 'variant')->get() : collect();

        return view('user.cart', compact('items'));
    }

    public function update(Request $request)
    {
        Log::info('Cart update called', ['ip' => $request->ip(), 'payload' => $request->all()]);
        $request->validate([
            'detail_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $detail = CartDetail::findOrFail($request->detail_id);
        if ($detail->cart->user_id !== Auth::id()) {
            Log::warning('Unauthorized cart update attempt', ['user_id' => Auth::id(), 'detail_id' => $request->detail_id]);
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $oldQty = $detail->quantity;
        $detail->quantity = $request->quantity;
        $detail->save();

        Log::info('Cart detail updated', ['detail_id' => $detail->id, 'old_qty' => $oldQty, 'new_qty' => $request->quantity]);

        return response()->json(['success' => true]);
    }

    public function destroy($detail)
    {
        $detail = CartDetail::findOrFail($detail);
        if ($detail->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $detail->delete();

        return response()->json(['success' => true]);
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login')->with('error', 'Vui lòng đăng nhập để thanh toán.');
        }

        $selectedDetailIds = $request->input('selected_items', []);
        Log::info('Checkout request', ['selected' => $selectedDetailIds, 'user' => Auth::id()]);
        $cart = Auth::user()->cart;
        if (!$cart) {
            return redirect()->route('user.cart.index')->with('error', 'Giỏ hàng trống.');
        }

        $items = $cart->items()->with('product', 'variant')->whereIn('id', $selectedDetailIds)->get();
        Log::info('Items found', ['count' => $items->count(), 'ids' => $items->pluck('id')->toArray()]);

        if ($items->isEmpty()) {
            return redirect()->route('user.cart.index')->with('error', 'Vui lòng chọn sản phẩm để thanh toán.');
        }

        return view('user.checkout', compact('items'));
    }
}
