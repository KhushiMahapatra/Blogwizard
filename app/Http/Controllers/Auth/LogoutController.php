<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // Import the Request class

class LogoutController extends Controller
{
    /**
     * Handle the logout request.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request) // Accept Request as a parameter
    {
        Auth::logout(); // Log the user out

        // Inside your controller after logging out
        return redirect()->route('welcome');
// Redirect to the home page or any other page
    }
}
