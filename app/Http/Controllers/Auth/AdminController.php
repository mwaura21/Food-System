<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth:admin');

    }
    /**
     * show dashboard.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin');

    }

    public function showupdateform()
    {

        return view('admin.update_profile');
        
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
    
        return redirect()->route('admin.dashboard')->with('message','Account updated successfully');
    }
    
}