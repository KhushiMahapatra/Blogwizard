<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request; // Correct namespace for Request
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use \Illuminate\Foundation\Auth\RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                // Custom regex for allowed email domains and providers
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|hotmail\.com|aol\.com|hotmail\.co\.uk|hotmail\.fr|msn\.com|[a-zA-Z0-9.-]+(\.com|\.in|\.co\.in))$/',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/', // At least one lowercase letter
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[0-9]/', // At least one digit
                'regex:/[@$!%*?&]/', // At least one special character
                'confirmed', // Must match the password_confirmation field
            ],
        ], [
            'email.regex' => 'The email address must end with .com, .in, or .co.in and belong to a valid provider (e.g., gmail.com, yahoo.com, hotmail.com).',
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function registered(Request $request, $user)
    {
        // Flash the user's name to the session
        session()->flash('user_name', $user->name);
    }
    
}
