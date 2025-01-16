<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        
        return view('admin.products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::find($id)->load('category');
        if (is_null($product)) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        
        return view('admin.products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'integer|min:0',
                'imagen' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:5000',
            ]);

            $product = new Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;
            // $product->discount_type = $request->discount_type;
            // $product->discount_value = $request->discount_value;

            if ($request->hasFile("imagen")) {
                // Obtener la imagen del request
                $image = $request->file('imagen');
            
                // Crear un nombre único para la imagen
                $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            
                // Definir la ruta de la carpeta de destino
                $destinationPath = public_path('assets/images/products/');
            
                // Verificar si la carpeta existe, si no, crearla
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }
            
                // Mover la imagen a la carpeta de destino
                $image->move($destinationPath, $imageName);

                $product->image = $imageName;
            }

            $product->save();

            if (!empty($request->categories)) {
                foreach ($request->categories as $category) {
                    $productCategory = new CategoryProduct();
                    $productCategory->category_id = $category;
                    $productCategory->product_id = $product->id;
                    $productCategory->save();
                }
            }

            return response()->json(['message' => 'Product created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }

    public function edit($id)
    {
        $product = Product::find($id)->load('category');
        $categories = Category::all();

        if (is_null($product)) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'integer|min:0',
                'imagen' => 'image|mimes:jpg,png,jpeg,gif,svg|max:5000',
            ]);

            $product = Product::find($id);
            if (is_null($product)) {
                return response()->json(['message' => 'Product not found'], 404);
            }
            
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;
            // $product->discount_type = $request->discount_type;
            // $product->discount_value = $request->discount_value;
            
            if ($request->hasFile("imagen")) {
                // Obtener la imagen del request
                $image = $request->file('imagen');
            
                // Crear un nombre único para la imagen
                $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            
                // Definir la ruta de la carpeta de destino
                $destinationPath = public_path('assets/images/products/');
            
                // Verificar si la carpeta existe, si no, crearla
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }
            
                // Mover la imagen a la carpeta de destino
                $image->move($destinationPath, $imageName);

                $product->image = $imageName;
            }

            $product->save();

            CategoryProduct::where('product_id', $product->id)->delete();

            if (!empty($request->categories)) {
                foreach ($request->categories as $category) {
                    $productCategory = new CategoryProduct();
                    $productCategory->category_id = $category;
                    $productCategory->product_id = $product->id;
                    $productCategory->save();
                }
            }

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
