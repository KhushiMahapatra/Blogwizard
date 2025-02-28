<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\Profile\UpdateRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function openProfilePage()
    {
        $user = auth()->user();
        return view('auth.profile', compact('user'));
    }

    public function storeProfile(UpdateRequest $request)
    {
        $user = auth()->user();

        $user->update($request->except('password'));

        if ($request->filled('password')) {
            $request->validate([
                'password' => [
                    'string',
                    'min:8',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*?&]/',
                    'confirmed',
                ],
                'password_confirmation' => 'required|string|min:8',
            ], [
                'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.',
                'password.confirmed' => 'The password confirmation does not match.',
            ]);

            // Update the password
            $user->update(['password' => bcrypt($request->password)]);
        }

        // Flash success message
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
