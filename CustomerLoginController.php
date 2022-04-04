<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\Customer;
use App\Models\County;
use App\Models\CustomerVerify;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Auth;
use Route;
use DB;
use Mail;
use Session;

class CustomerLoginController extends Controller
{
   
    public function __construct()
    {
      $this->middleware('guest:customer', ['except' => ['logout']]);
    }
    
    public function showLoginForm()
    {
      return view('auth.customer_login');
    }
    
    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]);
      // Attempt to log the user in
      if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password]))
       {

        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password, 'is_enabled' => 1]))
        {

        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password, 'is_email_verified' => 1]))
        {
            // if successful, then redirect to their intended location
            return redirect()->intended(route('customer.dashboard'));
        }
        // if not verified logout, then redirect to their intended location
        Auth::guard('customer')->logout();

        return redirect(route('customer.login'))->with('error-message','Account not verified, please verify to log in');
       }
       Auth::guard('customer')->logout();

       return redirect(route('customer.login'))->with('error-message','Account not enabled, contact admin');

      }
      return redirect()->back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
        'password' => 'The provided credentials do not match our records.',
    ])->withInput($request->only('email'));
    }
    
    public function logout()
    {
        Session::flush();
        Auth::guard('customer')->logout();
        return redirect('/customer')->with('message', 'You have successfully logged out');
    }

    public function showRegisterForm()
    {
      $counties = County::get();

      
      return view('auth.customer_register',compact('counties'));
    }

    public function register(Request $request)
    {

      // Validate the form data
      $this->validate($request, [
        'first_name' => 'required',
        'last_name' => 'required',
        'counties' => 'required',
        'email' => 'required|email|unique:customer',
        'phone_number' => 'required|unique:customer',
        'password' => 'required|confirmed|min:6'
      ]);

      $data = $request->all();
      $check = $this->create($data);
      $message = 'You have successfully registered your account. Wait for account approval';
      $role = 'Customer';
       

      Mail::send('email.emailAcceptEmail', ['role' => $role], function($message) use($request){

        $admin = DB::table('admin')->first();
        $email = $admin->email;


        $message->to($email);
        $message->subject('Customer has registered an account');
    });  
        return redirect()->route('customer.login')->with('message', $message);
    }

    public function create(array $data)
    {
      return Customer::create([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'counties' => $data['counties'],
        'email' => $data['email'],
        'phone_number' => $data['phone_number'],
        'password' => Hash::make($data['password'])
      ]);
    } 

    public function dashboard()
    {
        if(Auth::check()){
            return view('customer.dashboard');
        }
  
        return redirect()->route("customer.login")->with('error-message', 'Opps! You do not have access');
    }

    public function verifyAccount($token)
    {
        $verifyCustomer = CustomerVerify::where('token', $token)->first();
  
        $message = 'Sorry your email cannot be identified.';
        if(!is_null($verifyCustomer) ){
            $customer = $verifyCustomer->customer;
              
            if(!$customer->is_email_verified) {
                $verifyCustomer->customer->is_email_verified = 1;
                $verifyCustomer->customer->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }
   
      return redirect()->route('customer.login')->with('message', $message);
    }
}