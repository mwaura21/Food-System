<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Mail;
use Str;
use App\Models\VendorVerify;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ManageVendorController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth:admin');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $vendors = Vendor::latest()->paginate(5, ['*'], 'vendors');
        $customers = Customer::latest()->paginate(5, ['*'], 'customers');
        
        return view('admin.users_index',compact('vendors','customers'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */ 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        //
    }

    public function enable(Request $request, $vendor) 
    { 

        $vendor_enable = Vendor::where('id', $vendor)->first();

        if (!$vendor_enable) 
        {

            return redirect()->route('users.index')->with('vendor-error-message','Vendor cannot be enabled ');

        }
    
        $vendor_enable->is_enabled =  $request->input('is_enabled');

        $vendor_enable->save();

        $role = 'Vendor';

        if($vendor_enable->is_email_verified == 0)
        {

            $token = Str::random(64);

            VendorVerify::create([
                  'vendor_id' => $vendor_enable->id, 
                  'token' => $token,
                ]);
      
            Mail::send('email.emailVerificationEmailVendor', ['token' => $token], function($message) use($request){

                  $message->to($request->email);
                  $message->subject('Email Verification Mail');

            }); 
        
            return redirect()->route('users.index')->with('vendor-message','Vendor has been enabled ');

        }

        elseif($vendor_enable->is_email_verified == 1)
        {

            $role = 'Vendor';

            Mail::send('email.accountEnableEmailVendor', ['role' => $role], function($message) use($request){
                    $message->to($request->email);
                    $message->subject('Account Enabled');
            }); 

            return redirect()->route('users.index')->with('vendor-message','Vendor has been enabled ');

        }
    } 

    public function disable(Request $request, $vendor) 
    { 

        $vendor_disable = Vendor::where('id', $vendor)->first();

        if (!$vendor_disable) 
        {

            return redirect()->route('users.index')->with('vendor-error-message','Vendor cannot be Disabled ');

        }
    
        $vendor_disable->is_enabled =  $request->input('is_enabled');

        $vendor_disable->save();

        $role = 'Vendor';

        Mail::send('email.accountDisabledEmail', ['role' => $role], function($message) use($request){
              $message->to($request->email);
              $message->subject('Account Disabled');
        }); 
    
        return redirect()->route('users.index')->with('vendor-message','Vendor has been disabled ');

    }

    public function vendorOrders(Request $request, Vendor $vendor)
    {

        $order = Order::latest()
        ->where('vendor', '=', $vendor->id)
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
    
        return view('admin.vendororders', ['orders' => $paginatedorders]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor, Request $request)
    {

        $role= 'Vendor';

        Mail::send('email.accountDeletedEmail',['role' => $role], function($message) use($request){
            $email = $request->vendor->email;
            $message->to($email);
            $message->subject('Deleted Account');
        }); 

        $vendor->delete();

        return redirect()->route('users.index')->with('vendor-message','Vendor deleted successfully');
        
    }
}
