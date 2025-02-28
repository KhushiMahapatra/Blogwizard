<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller {
    // Display all services
    public function index() {
        $services = Service::all();
        return view('pages.services', compact('services'));
    }

    // Show admin panel for editing services
    public function edit() {
        $services = Service::all();
        return view('admin.edit_services', compact('services'));
    }

    // Update service data
    public function update(Request $request) {
        // Validate input
        $request->validate([
            'services' => 'required|array',
            'services.*.description' => 'required|string',
        ]);

        // Loop through submitted service data and update each service
        foreach ($request->services as $id => $data) {
            $service = Service::find($id);

            if ($service) {
                $service->update([
                    'description' => $data['description'],
                ]);
            }
        }

        return redirect()->route('admin.services.edit')->with('success', 'Services updated successfully.');
    }

    public function store(Request $request) {
        $request->validate([

            'description' => 'required|string',

        ]);

        Service::create([

            'description' => $request->description,
        ]);

        return redirect()->route('admin.services.edit')->with('success', 'New service added successfully.');
    }

    public function destroy($id) {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.services.edit')->with('success', 'Service deleted successfully.');
    }

    public function viewservice() {
        $services = Service::all();
        return view('admin.pages.viewservice', compact('services'));
    }

}
