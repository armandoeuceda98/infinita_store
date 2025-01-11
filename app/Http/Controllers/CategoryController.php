<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all()->load('products');

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'string',
            ]);
    

            $exist = Category::where('name', $request->name)->first();

            if ($exist) {
                return response()->json(['message' => 'Category already exists'], 409);
            }

            $category = Category::create($request->all());
            
            return response()->json(['message' => 'Category created successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create category'], 409);
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);

        if (is_null($category)) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'string',
            ]);
    
            $category = Category::find($id);
            if (is_null($category)) {
                return response()->json(['message' => 'Category not found'], 404);
            }
    
            $category->update($request->all());
            
            return response()->json(['message' => 'Category updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update category'], 409);
        }
    }

    public function changeStatus($id)
    {
        try {
            $category = Category::find($id);
            if (is_null($category)) {
                return response()->json(['message' => 'Category not found'], 404);
            }
    
            if ($category->status == 'active') {
                $category->status = 'inactive';
            } else {
                $category->status = 'active';
            }
            
            $category->save();

            return response()->json(['message' => 'Category inactivated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage() ], 409);
        }
    }
}
