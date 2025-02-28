<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $about = AboutUs::first(); // Fetch the first record from the about_us table
        return view('pages.about', compact('about')); // Pass the $about variable to the view
    }

    public function show()
    {
        $about = AboutUs::first(); // Fetch the first record from the AboutUs table
        return view('about', compact('about')); // Pass the variable to the view
    }
    public function edit()
    {
        $about = AboutUs::first(); // Assuming there's only one record
        return view('admin.about.edit', compact('about'));
    }
    public function about()
    {
        $about = \App\Models\AboutUs::first();
        return view('pages.about', compact('about'));
    }
    public function update(Request $request)
    {
        $request->validate([

            'description' => 'required|string',
        ]);

        $about = AboutUs::first();
        $about->update($request->all());

        return redirect()->back()->with('success', 'About Us content updated successfully.');
    }
    public function viewabout() {
        $about = AboutUs::first(); // Retrieve the first record from the AboutUs model
        \Log::info($about); // Log the $about variable
        return view('admin.pages.viewabout', compact('about')); // Pass the $about variable to the view
    }


}
