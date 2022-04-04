<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Route;
use Session;
use App\User;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;



class AdminLoginController extends Controller
{
   
    public function __construct()
    {

        $this->middleware('guest:admin', ['except' => ['logout']]);

    }

    public function showLoginForm()
    {

      return view('auth.admin_login');

    }

    public function login(Request $request)
    {

        // Validate the form data
        $this->validate($request,[
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

      // Attempt to log the user in
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) 
        {

          // if successful, then redirect to their intended location
          return redirect()->intended(route('admin.dashboard'));

        } 
      // if unsuccessful, then redirect back to the login with the error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
            'password' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));

    }

    public function logout()
    {

        Session::flush();

        Auth::guard('admin')->logout();

        return redirect('/admin');

    }

    public function showRegisterForm()
    {

        return view('auth.admin_register');

    }

    public function register(Request $request)
    {

        // Validate the form data
        $this->validate($request, [
            'name' => 'required', 
            'email' => 'required|email|unique:admin',
            'phone_number' => 'required|unique:admin',
            'password' => 'required|confirmed|min:6'
        ]);

        $data = $request->all();
        $check = $this->create($data);

        // Attempt to log the user in
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) 
        {

            // if successful, then redirect to their intended location
            return redirect()->intended(route('admin.dashboard'));

        } 

        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'));

    }

    public function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password'])
        ]);
    } 
}