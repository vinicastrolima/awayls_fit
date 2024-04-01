<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class CartController extends Controller
{
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $user = $request->user(); // Obter o usuário autenticado
        $cart = $user->cart()->firstOrNew(); // Obter o carrinho do usuário ou criar um novo
    
        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
    
            if ($product->quantity < $item['quantity']) {
                return response()->json(['error' => 'Not enough stock available for product: ' . $product->name], 400);
            }
    
            // Adicionar o item ao carrinho
            $cartItems = $cart->items ?? [];
            $cartItems[] = [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ];
            $cart->items = $cartItems;
        }
    
        $cart->save();
    
        return response()->json(['message' => 'Cart updated successfully'], 200);
    }
    
}
