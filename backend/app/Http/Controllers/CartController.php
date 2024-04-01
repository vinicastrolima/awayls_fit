<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;


class CartController extends Controller
{

    public function getCartDetails()
    {
        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        // Buscar os detalhes dos produtos no carrinho
        $cartItems = $cart->items;
        $cartDetails = [];

        foreach ($cartItems as $item) {
            $product = Product::find($item['product_id']);

            if (!$product) {
                // Se o produto não for encontrado, continue para o próximo
                continue;
            }

            $cartDetails[] = [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'name' => $product->name,
                'name' => $product->price,
                // Adicione aqui outros detalhes do produto que deseja incluir
            ];
        }

        return response()->json(['cart' => $cartDetails]);
    }

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
    
        $user = $request->user(); 
        $cart = $user->cart()->firstOrNew();
    
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

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        // Validação dos dados de entrada
        $validator = Validator::make($request->all(), [
            'delivery_address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:credit_card,cash',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Calcula o total da compra
        $totalAmount = 0;
        foreach ($cart->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $totalAmount += $product->price * $item['quantity'];

            // Subtrai a quantidade do produto do estoque
            $product->decrement('quantity', $item['quantity']);
        }

        // Cria o pedido
        $order = new Order([
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
            'items' => $cart->items,
            'delivery_address' => $request->input('delivery_address'),
            'payment_method' => $request->input('payment_method'),
        ]);
        $order->save();

        // Limpa o carrinho do usuário
        $cart->delete();

        return response()->json($order, 201);
    }

    public function listOrders()
    {
        $orders = Order::all(['id', 'total_amount', 'payment_method']);
        return response()->json($orders);
    }

    public function getOrderDetails($id)
    {
        $order = Order::findOrFail($id);
        $items = collect($order->items); 
    
        $items = $items->map(function ($item) {
            $product = Product::findOrFail($item['product_id']);
            $item['name'] = $product->name;
            unset($item['product_id']);
            return $item;
        });
    
        $order->items = $items;
    
        return response()->json($order);
    }
    
}
