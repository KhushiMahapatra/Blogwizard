<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\ContactInfo;

class ContactController extends Controller {
    public function submit(Request $request) {
        // Validate the form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|[a-zA-Z0-9.-]+\.(com|in))$/'
            ],
            'message' => 'required|string',
        ]);

        // Store in database
        ContactMessage::create($request->all());

        return redirect()->back()->with('success', 'Message Sent Successfully!');
    }

    // Show all messages in the admin panel
    public function index() {
        $messages = ContactMessage::latest()->paginate(10);
        return view('admin.contact.contact', compact('messages'));
    }
    public function showContactPage() {
        $contact = ContactInfo::first();
        return view('pages.contact', compact('contact'));
    }
    public function viewcontact() {
        $messages = ContactMessage::latest()->paginate(10);
        return view('admin.pages.viewcontact', compact('messages'));
    }
    public function viewContactInfo() {
        $contact = ContactInfo::first();
        return view('admin.pages.viewcontactinfo', compact('contact'));
    }
    public function destroy($id) {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('alert-success', 'Message deleted successfully.');
    }

}
