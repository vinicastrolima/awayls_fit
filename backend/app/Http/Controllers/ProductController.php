<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appUrl = env('CAMINHO_STORAGE');
    
        $products = Product::all();
    
        $products->transform(function ($product) use ($appUrl) {
            $product->image_url = $product->path_image ? $appUrl . Storage::url($product->path_image) : null;
            return $product;
        });
    
        return response()->json($products);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::check() || !Auth::user()->admin) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $data = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images'); 
            $imagePath = str_replace('public/', '', $imagePath);
            $data['path_image'] = $imagePath;
        }
    
        $product = Product::create($data);
    
        return response()->json($product, 201);
    }

    public function highlights()
    {
        // Obter o APP_URL do arquivo .env
        $appUrl = env('CAMINHO_STORAGE');
    
        // Busca os últimos 12 produtos cadastrados
        $products = Product::latest()->take(12)->get();
    
        // Transforma os produtos para incluir URLs das imagens
        $products->transform(function ($product) use ($appUrl) {
            $product->image_url = $product->path_image ? $appUrl . Storage::url($product->path_image) : null;
            return $product;
        });
    
        return response()->json($products);
    }

    public function updateQuantity(Request $request)
    {
        if (!Auth::check() || !Auth::user()->admin) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::find($request->input('id'));

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->quantity = $request->input('quantity');
        $product->save();

        return response()->json($product);
    }

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appUrl = env('CAMINHO_STORAGE');
    
        $product = Product::findOrFail($id);
    
        $product->image_url = $product->path_image ? $appUrl . Storage::url($product->path_image) : null;
    
        return response()->json($product);
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'path_image' => 'nullable|string',
        ]);

        $product->update($validatedData);
        return response()->json($product, 200);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }
}
