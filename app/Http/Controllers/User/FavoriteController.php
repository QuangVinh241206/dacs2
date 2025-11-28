<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $productId = $request->input('product_id');

        $existing = Favorite::where('user_id', $user->id)->where('product_id', $productId)->first();
        if ($existing) {
            $existing->delete();
            $status = 'removed';
        } else {
            Favorite::create(['user_id' => $user->id, 'product_id' => $productId]);
            $status = 'added';
        }

        $count = Favorite::where('product_id', $productId)->count();

        return response()->json(['status' => $status, 'count' => $count]);
    }
}
