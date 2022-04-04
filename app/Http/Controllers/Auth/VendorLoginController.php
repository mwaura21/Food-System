<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\Customer;
use App\Models\County;
use App\Models\VendorVerify;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Auth;
use Route;
use DB;
use Session;

use Mail;

class VendorLoginController extends Controller
{
   
    public function __construct()
    {

        $this->middleware('guest:vendor', ['except' => ['logout']]);

    }
    
    public function showLoginForm()
    {

        return view('auth.vendor_login');

    }
  
    public function login(Request $request)
    { 
        // Validate the form data
        $this->validate($request,[
          'email'   => 'required|email',
          'password' => 'required|min:6'
        ]);

        // Attempt to log the user in
        if (Auth::guard('vendor')->attempt(['email' => $request->email, 'password' => $request->password]))
        {

            if (Auth::guard('vendor')->attempt(['email' => $request->email, 'password' => $request->password, 'is_enabled' => 1]))
            {

                if (Auth::guard('vendor')->attempt(['email' => $request->email, 'password' => $request->password, 'is_email_verified' => 1]))
                {

                    // if successful, then redirect to their intended location
                    return redirect()->intended(route('vendor.dashboard'));
                    
                }

                // if not verified logout, then redirect to their intended location
                Auth::guard('vendor')->logout();

                return redirect(route('vendor.login'))->with('error-message','Account not verified, please verify to log in');

            }

            Auth::guard('vendor')->logout();

            return redirect(route('vendor.login'))->with('error-message','Account not enabled, contact admin');

        }

          return redirect()->back()->withErrors([
              'email' => 'The provided credentials do not match our records.',
              'password' => 'The provided credentials do not match our records.',
          ])->withInput($request->only('email'));
    } 
  
    public function logout()
    {

        Session::flush();
        Auth::guard('vendor')->logout();
        return redirect('/vendor'); 

    }

    public function showRegisterForm()
    {
      $counties = County::get();

      return view('auth.vendor_register',compact('counties'));

    }

    public function register(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
          'name' => 'required',
          'counties' => 'required',
          'email' => 'required|email|unique:vendor',
          'phone_number' => 'required|unique:vendor',
          'password' => 'required|confirmed|min:6'
        ]);

        $data = $request->all();
        $check = $this->create($data);
        $message = 'You have successfully registered your account. Wait for account approval';
        $role = 'Vendor';
            
        Mail::send('email.emailAcceptEmail', ['role' => $role], function($message) use($request){

          $admin = DB::table('admin')->first();
          $email = $admin->email;
          $message->to($email);
          $message->subject('Vendor has registered an account');

        });  

        return redirect()->route('vendor.login')->with('message', $message);
        
    }

    public function create(array $data)
    {

        return Vendor::create([
          'name' => $data['name'],
          'counties' => $data['counties'],
          'email' => $data['email'],
          'phone_number' => $data['phone_number'],
          'logo' => 'default.png',
          'password' => Hash::make($data['password'])
        ]);
        
    }

    public function dashboard()
    {

        if(Auth::check())
        {

            return view('vendor.dashboard');

        }

        return redirect()->route("vendor.login")->with('error-message', 'Opps! You do not have access');

    }

    public function verifyAccount($token)
    {

        $verifyVendor = VendorVerify::where('token', $token)->first();
        $message = 'Sorry your email cannot be identified.';

        if(!is_null($verifyVendor) )
        {

            $vendor = $verifyVendor->vendor;
              
            if(!$vendor->is_email_verified) 
            {

                $verifyVendor->vendor->is_email_verified = 1;
                $verifyVendor->vendor->save();
                $message = "Your e-mail is verified. You can now login.";

            } 

            else 
            {

                $message = "Your e-mail is already verified. You can now login.";

            }

        }

      return redirect()->route('vendor.login')->with('message', $message);

      }

} 