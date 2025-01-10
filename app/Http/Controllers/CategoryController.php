<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        
        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        
        return view('categories.show', compact('category'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
    

            $exist = Category::where('name', $request->name)->first();

            if ($exist) {
                return response()->json(['message' => 'Category already exists'], 409);
            }

            $category = Category::create($request->all());
            
            return response()->json($category, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create category'], 409);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'sometimes|required|string|max:255',
            ]);
    
            $category = Category::find($id);
            if (is_null($category)) {
                return response()->json(['message' => 'Category not found'], 404);
            }
    
            $category->update($request->all());
            return response()->json($category);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update category'], 409);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            if (is_null($category)) {
                return response()->json(['message' => 'Category not found'], 404);
            }
    
            $category->delete();
            return response()->json(['message' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete category'], 409);
        }
    }
}
