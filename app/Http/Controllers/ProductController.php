<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::find($id)->load('category');
        if (is_null($product)) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        
        return view('products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'integer|min:0',
                'status' => 'required|in:available,unavailable',
                'image' => 'required|string|max:255',
                'discount_type' => 'required|in:fixed,percent',
                'discount_value' => 'required|numeric|min:0',
            ]);

            $product = Product::create($request->all());

            return response()->json($product, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create product'], 409);
        }
    }

    public function edit($id)
    {
        $product = Product::find($id)->load('category');
        $categories = Category::all();

        if (is_null($product)) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
                'price' => 'sometimes|required|numeric|min:0',
                'stock' => 'sometimes|integer|min:0',
                'status' => 'sometimes|required|in:available,unavailable',
                'image' => 'sometimes|required|string|max:255',
                'discount_type' => 'sometimes|required|in:fixed,percent',
                'discount_value' => 'sometimes|required|numeric|min:0',
            ]);

            $product = Product::find($id);
            if (is_null($product)) {
                return response()->json(['message' => 'Product not found'], 404);
            }
            $product->update($request->all());
            return response()->json($product);
        } catch (\Exception $e) {
            return response()->json(['message' => $e], 409);
        }   
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->delete();
        return response()->json(null, 204);
    }
}
