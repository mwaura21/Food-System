<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\County;
use App\Models\Order;
use Auth;
use App\Models\SubVendor;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Mail;
use DB;
use Carbon\Carbon; 
use Illuminate\Support\Str;

class VendorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth:vendor')->except(['showpasswordform', 'savepassword']);

    }
    /**
     * show dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('vendor');

    }

    public function create()
    {

        return view('vendor.create');

    }

    public function viewsubvendors()
    { 

        $subvendors = SubVendor::latest()->paginate(5);

        return view('vendor.manage',compact('subvendors'));

    }

    public function vieworder(Request $request)
    {

        $id =Auth::user()->id;

        $order = Order::latest()
        ->where('vendor', '=', $id)
        ->orderBy('order_id', 'asc')
        ->get()
        ->groupBy('order_id');

        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
 
        // Create a new Laravel collection from the array data
        $orderCollection = collect($order);
 
        // Define how many products we want to be visible in each page
        $perPage = 4;
 
        // Slice the collection to get the products to display in current page
        $currentPageorders = $orderCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
 
        // Create our paginator and pass it to the view
        $paginatedorders= new LengthAwarePaginator($currentPageorders , count($orderCollection), $perPage);
 
        // set url path for generted links
        $paginatedorders->setPath($request->url());
    
        return view('vendor.orders', ['orders' => $paginatedorders]);

    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required|unique:subvendor',
            'email' => 'required|email|unique:subvendor',
        ]);
    
        $data = $request->all();
        $check = $this->make($data);

        $id = SubVendor::all()->last()->id;
        $token = Str::random(64);

      
        Mail::send('email.registrationEmail', ["id"=>$id], function($message) use($request){
                $message->to($request->email);
                $message->subject('Registration of your Sub Vendor account');
            });  
     
        return redirect()->route('vendor.manage')->with('message','Sub Vendor created successfully.');
    }

    public function make(array $data)
    {

        return SubVendor::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'phone_number' => $data['phone_number'],
        ]);

    } 

    public function update(Request $request, SubVendor $subvendor)
    {

        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
        ]);
    
        $subvendor->update($request->all());
    
        return redirect()->route('vendor.manage')->with('message','Sub Vendor updated successfully');

    } 

    public function showpasswordform($id) 
    { 

        return view('vendor.subvendorpassword', ['id' => $id]);

    }
 
    public function savepassword(Request $request, SubVendor $subvendor)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);
    
        $updatePassword = DB::table('sub_vendor')
        ->where(['id' => $request->id])
        ->first();

        $subvendor = SubVendor::where('id', $request->id)
        ->update(['password' => Hash::make($request->password)]);
    
        return redirect()->route('subvendor.login')->with('message','Account made successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    
    public function destroy(SubVendor $subvendor)
    {

        $subvendor->delete();
    
        return redirect()->route('vendor.manage')->with('message','Sub Vendor deleted successfully');

    }

    public function ready(Request $request, Order $order) 
    { 

        $order_ready = Order::where('id', $order->id)->first();

        if (!$order_ready) 
        {

            return redirect()->route('orders')->with('error-message','Order cannot be Ready ');

        }
        
        $order_ready->status =  $request->input('status');
       
        $order_ready->save();

        $details = [
            'name' => $order->first_name .' '.$order->last_name,
            'order' => $order->name,
            'quantity' => $order->quantity,
            'number' => $order->order_id,
        ];

        Mail::send('email.orderReady', ['details' => $details], function($message) use($request){
              $message->to($request->email);
              $message->subject('Your Order is Ready');
          }); 
    
        return redirect()->route('orders')->with('message','Order updated');

    }

    public function enable(Request $request, $subvendor)
    { 

        $subvendor_enable = SubVendor::where('id', $subvendor)->first();

        $request->validate([
            'email' => 'required',
        ]);

        if (!$subvendor_enable) 
        {

            return redirect()->route('vendor.manage')->with('error-message','Sub Vendor cannot be enabled ');

        }
    
        $subvendor_enable->is_enabled =  $request->input('is_enabled');

        $subvendor_enable->save();

        $role = 'Sub Vedor';
      
        if($subvendor_enable->is_email_verified == 0)
        {

            $token = Str::random(64);

            SubVendorVerify::create([
                  'subvendor_id' => $subvendor_enable->id, 
                  'token' => $token,
                ]);
      
            Mail::send('email.emailVerificationEmail', ['token' => $token], function($message) use($request){

                  $message->to($request->email);
                  $message->subject('Email Verification Mail');

              }); 
        
            return redirect()->route('vendor.manage')->with('message','Sub Vendor has been enabled ');

        }

        elseif($subvendor_enable->is_email_verified == 1)
        {

            $role = 'Sub Vendor';

        Mail::send('email.accountEnabledEmail', ['role' => $role], function($message) use($request){
              $message->to($request->email);
              $message->subject('Account Enabled');
        }); 
    
        return redirect()->route('vendor.manage')->with('message','Sub Vendor has been enabled');

        }
        
    }

    public function disable(Request $request, $subvendor) 
    { 

        $subvendor_disable = SubVendor::where('id', $subvendor)->first();

        if (!$subvendor_disable) 
        {

            return redirect()->route('vendor.manage')->with('error-message','Sub Vendor cannot be disabled ');

        }
    
        $subvendor_disable->is_enabled = $request->input('is_enabled');

        $subvendor_disable->save();

        $role = 'Sub Vendor';

        Mail::send('email.accountDisabledEmail', ['role' => $role], function($message) use($request){
              $message->to($request->email);
              $message->subject('Account Disabled');
        }); 

    
        return redirect()->route('vendor.manage')->with('message','Sub Vendor has been disabled ');

    }

    public function showupdateform()
    {

        $counties = County::get();

        return view('vendor.update_profile')->with('counties', $counties);

    }

    public function updateprofile(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'counties' => 'required',
            'phone_number' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
          ]);
 
        $current_user = Auth::user();
        $current_user->name = $request->get('name');
        $current_user->counties = $request->get('counties');
        $current_user->phone_number = $request->get('phone_number');

        if (isset($request->logo)) 
        {

            $logoName = time().'.'.$request->logo->extension();  
            $request->logo->storeAs('public/images', $logoName);
            $current_user->logo = $logoName;

        }

        $current_user->update();
      
        return redirect()->route('vendor.dashboard')->with('message','Account updated successfully');
        
    }
}