<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactInfo;

class ContactInfoController extends Controller {
    public function edit() {
        $contact = ContactInfo::first();
        return view('admin.contact.edit', compact('contact'));
    }

    public function update(Request $request) {
        // Validate the incoming request
        $request->validate([
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        // Retrieve the first contact info record or create a new one
        $contact = ContactInfo::first();
        if (!$contact) {
            $contact = new ContactInfo();
        }

        // Update the contact information
        $contact->update([
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Contact Info Updated Successfully!');
    }
    
}
