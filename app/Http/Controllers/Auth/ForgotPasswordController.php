<?php 
  
namespace App\Http\Controllers\Auth; 

use DB; 
use Mail; 
use Hash;
use Carbon\Carbon; 
use App\Models\Customer; 
use Illuminate\Support\Str;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
      /**
       * Write code on Method
       *
       * @return response()
       */
    public function showForgetPasswordForm()
    {

        return view('auth.forgetPassword');

    }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:customer',
        ]);

        $token = Str::random(64);
        $role = "customer";

        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token,
            'role' =>  $role,
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('message', 'We have e-mailed your password reset link!');

    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm($token) 
    { 

        return view('auth.forgetPasswordLink', ['token' => $token]);

    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:customer',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
                            ->where([
                            'email' => $request->email, 
                            'token' => $request->token
                            ])
                            ->first();

        if(!$updatePassword)
        {

            return back()->withInput()->with('error', 'Invalid token!');

        }

        $customer = Customer::where('email', $request->email)
                    ->update(['password' => Hash::make($request->password)]);

                    DB::table('password_resets')->where(['email'=> $request->email, 'token' => $request->token])->update(['token' => null]);

        return redirect()->intended(route('customer.dashboard'))->with('message', 'Your password has been changed!');
        
    }
}