<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\StaticContent;
use App\Http\Controllers\Admin\AboutUsController;
use App\Models\PrivacyPolicy;
use App\Models\Term;
use App\Http\Controllers\Admin\TermController;
use App\Models\AboutUs;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.index');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
    public function submit(Request $request)
    {

    }


    public function services()
    {
        return view('pages.services');
    }
    public function term()
    {
        $term = Term::first();
        return view('pages.term', compact('term'));    }

    public function faq()
    {
        return view('pages.faq');
    }
    public function showaboutus()
    {
        return view('pages.about');
    }
    public function show() {
        $policy = PrivacyPolicy::first();
        return view('pages.policy', compact('policy'));
    }

    public function editPolicy() {
        $policy = PrivacyPolicy::first();
        return view('admin.about.policy.edit_policy', compact('policy'));
    }

    public function updatePolicy(Request $request) {
        $request->validate([
            'content' => 'required',
        ]);

        $policy = PrivacyPolicy::first();
        if ($policy) {
            $policy->update(['content' => $request->input('content')]);
        } else {
            PrivacyPolicy::create(['content' => $request->input('content')]);
        }

        return redirect()->route('admin.about.policy.edit_policy')->with('success', 'Privacy Policy updated successfully.');
    }

    public function viewpolicy() {
        $policy = PrivacyPolicy::first();
        return view('admin.pages.viewpolicy', compact('policy'));
    }

}
