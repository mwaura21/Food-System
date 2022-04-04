<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\SubVendor;
use Auth;
use App\Http\Controllers\Controller;
use Mail;
use DB;
use Carbon\Carbon; 
use Illuminate\Support\Str;

class SubVendorController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth:subvendor');

    }

    public function index()
    {

        return view('subvendor');

    }

    public function showupdateform()
    {

        return view('vendor.update_subprofile');

    }

    public function updateprofile(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
        ]);
 
        $current_user = Auth::user();
        $current_user->name = $request->get('name');
        $current_user->phone_number = $request->get('phone_number');

        $current_user->update();
      
        return redirect()->route('subvendor.dashboard')->with('message','Account updated successfully');
        
    }
}
