<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Route;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Models\SubVendor;
use Session;

class SubVendorLoginController extends Controller
{
    public function __construct()
    {

        $this->middleware('guest:subvendor', ['except' => ['logout']]);

    }
    
    public function showLoginForm()
    {

        return view('auth.subvendor_login');

    }
    
    public function login(Request $request)
    { 

        // Validate the form data
        $this->validate($request,[
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Attempt to log the user in
        if (Auth::guard('subvendor')->attempt(['email' => $request->email, 'password' => $request->password]))
        {

          if (Auth::guard('vendor')->attempt(['email' => $request->email, 'password' => $request->password, 'is_enabled' => 1]))
          {

              // if successful, then redirect to their intended location
              return redirect()->intended(route('vendor.dashboard'));

          }
          // if not verified logout, then redirect to their intended location
          Auth::guard('vendor')->logout();

          return redirect(route('vendor.login'))->with('error-message','Account not enabled, contact vendor admin');

    }
        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
            'password' => 'The provided credentials do not match our records.',
        ]);

    } 

    public function logout()
    {

        Session::flush();
        Auth::guard('subvendor')->logout();
        return redirect('/subvendor'); 

    }

    public function dashboard()
    {

        if(Auth::check())
        {

            return view('subvendor.dashboard');

        }
  
        return redirect()->route("subvendor.login")->with('error-message', 'Opps! You do not have access');
        
    }

}
