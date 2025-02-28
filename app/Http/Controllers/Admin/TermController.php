<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    public function index()
    {
        $term = Term::first();
        return view('pages.term', compact('term'));
    }
    public function edit()
    {
        $term = Term::first();
        return view('admin.terms.edit', compact('term'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $term = Term::first(); // Assuming there's only one record
        $term->update(['content' => $request->content]);

        return redirect()->route('admin.terms.edit')->with('success', 'Terms updated successfully.');
    }
    public function viewterm()
    {
        $term = Term::first();
        return view('admin.pages.viewterm', compact('term'));
    }
}
