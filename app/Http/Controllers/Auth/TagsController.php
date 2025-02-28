<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function openTagsPage()
    {
        $tags = Tag::all();
        return view('auth.tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
            'description' => 'nullable|string|max:500',
        ]);

        Tag::create([
            'name' => $request->name,
            'description' => $request->description, // Include description
        ]);

        return redirect()->back()->with('alert-success', 'Tag added successfully.');
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->back()->with('alert-success', 'Tag deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $id, // Ensure unique except for the current tag
            'description' => 'nullable|string|max:500',
        ]);

        $tag = Tag::findOrFail($id);
        $tag->name = $request->name;
        $tag->description = $request->description; // Update description
        $tag->save();

        return redirect()->back()->with('alert-success', 'Tag updated successfully.');
    }
}
