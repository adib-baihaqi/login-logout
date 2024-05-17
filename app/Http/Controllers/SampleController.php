<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SampleController extends Controller
{
    // Method to display the login view
    function index()
    {
        return view('login'); // Return the 'login' view
    }

    // Method to display the registration view
    function registration()
    {
        return view('registration'); // Return the 'registration' view
    }

    // Method to validate registration input and create a new user
    function validate_registration(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name'         =>   'required', // Name is required
            'email'        =>   'required|email|unique:users', // Email is required, must be a valid email, and unique in the users table
            'password'     =>   'required|min:6', // Password is required and must be at least 6 characters long
            'role'         =>   'required',//Role is required
        ]);

        // Retrieve all validated data
        $data = $request->all();

        // Create a new user with the validated data
        User::create([
            'name'  =>  $data['name'], // Set the name
            'email' =>  $data['email'], // Set the email
            'password' => Hash::make($data['password']), // Hash and set the password
            'role' => $data['role'],
        ]);

        // Redirect to the login page with a success message
        return redirect('login')->with('success', 'Registration Completed, now you can login');
    }

    // Method to validate login input and authenticate the user
    public function validate_login(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'email' => 'required|email', // Email is required and must be a valid email
        'password'=> 'required'     // Password is required
    ]);

    // Only retrieve the email and password from the request
    $credentials = $request->only('email', 'password');

    // Attempt to authenticate the user with the provided credentials
    if (Auth::attempt($credentials)) {
        // Authentication passed...
        $user = Auth::user(); // Get the authenticated user

        // Check if the user is an admin
        if ($user->role == 'admin') {
            return redirect()->route('adminpage'); // Redirect to the admin page
        }

        // If the user is not an admin, redirect to the dashboard
        return redirect()->route('dashboard');
    }

    // If authentication fails, redirect back to the login page with a failure message
    return redirect()->route('login')->with('error', 'Login details are not valid');
}

    // Method to display the dashboard view if the user is authenticated
    function dashboard()
    {
        if(Auth::check())
        {
            return view('dashboard'); // Return the 'dashboard' view if the user is authenticated
        }

        // Redirect to the login page with a failure message if the user is not authenticated
        return redirect('login')->with('success', 'you are not allowed to access');
    }

    // Method to log out the user
    function logout()
    {
        Session::flush(); // Clear all session data

        Auth::logout(); // Log out the user

        return Redirect('login'); // Redirect to the login page
    }

    public function adminPage()
    {
        // Logic for adminPage
        return view('admin.adminpage');
    }
}

