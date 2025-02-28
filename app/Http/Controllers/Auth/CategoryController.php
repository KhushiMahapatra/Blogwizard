<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function openCategoriesPage()
    {
        $categories = Category::all();
        $categories = Category::with('parent')->get();

        return view('auth.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:500',
            'parent_id' => 'nullable|exists:categories,id', // Validate parent_id if provided

        ]);

        // Create a new category
        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'parent_id' => $request->parent_id, // Save the parent_id
            // Include description
        ]);

        return redirect()->back()->with('alert-success', 'Category added successfully.');
    }

    public function destroy($id)
    {
        // Find the category by ID and delete it
        $category = Category::findOrFail($id);
        $category->delete();

        // Redirect back with a success message
        return redirect()->back()->with('alert-success', 'Category deleted successfully.');
    }

    public function update(Request $request, $id)
{
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name,' . $id,
        'description' => 'nullable|string|max:500',
        'parent_id' => 'nullable|exists:categories,id',
    ]);

    // Find the category by ID and update it
    $category = Category::findOrFail($id);
    $category->name = $request->name;
    $category->description = $request->description;
    $category->parent_id = $request->parent_id; // Correctly update parent_id
    $category->save();

    // Redirect back with a success message
    return redirect()->back()->with('alert-success', 'Category updated successfully.');
}
}
