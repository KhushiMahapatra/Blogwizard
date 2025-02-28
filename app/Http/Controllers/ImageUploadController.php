<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif', // Validate image
        ]);

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName); // Save image in /public/uploads

            return response()->json(['location' => asset('uploads/' . $imageName)]);
        }

        return response()->json(['error' => 'Image upload failed'], 400);
    }
}
