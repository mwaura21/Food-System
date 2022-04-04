<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Mail;
use Str;
use App\Models\CustomerVerify;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ManageCustomerController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    public function enable(Request $request, $customer) 
    { 

        $customer_enable = Customer::where('id', $customer)->first();

        $request->validate([
            'email' => 'required',
        ]);

        if (!$customer_enable) 
        {

            return redirect()->route('users.index')->with('customer-error-message','Customer cannot be enabled ');

        }
    
        $customer_enable->is_enabled =  $request->input('is_enabled');

        $customer_enable->save();

        $role = 'Customer';
      
        if($customer_enable->is_email_verified == 0)
        {

            $token = Str::random(64);

            CustomerVerify::create([
                  'customer_id' => $customer_enable->id, 
                  'token' => $token,
            ]);
      
            Mail::send('email.emailVerificationEmail', ['token' => $token], function($message) use($request){

                $message->to($request->email);
                $message->subject('Email Verification Mail');

            }); 
        
            return redirect()->route('users.index')->with('customer-message','Customer has been enabled ');

        }

        elseif($customer_enable->is_email_verified == 1)
        {
            $role = 'Customer';

            Mail::send('email.accountEnabledEmail', ['role' => $role], function($message) use($request){
                    $message->to($request->email);
                    $message->subject('Account Enabled');
                }); 

            return redirect()->route('users.index')->with('customer-message','Customer has been enabled');

        }
        
    }

    public function disable(Request $request, $customer) 
    { 

        $customer_disable = Customer::where('id', $customer)->first();

        if (!$customer_disable) 
        {

            return redirect()->route('users.index')->with('customer-error-message','Customer cannot be disabled ');

        }
    
        $customer_disable->is_enabled =  $request->input('is_enabled');

        $customer_disable->save();

        $role = 'Customer';

        Mail::send('email.accountDisabledEmail', ['role' => $role], function($message) use($request){
              $message->to($request->email);
              $message->subject('Account Disabled');
        }); 

        return redirect()->route('users.index')->with('customer-message','Customer has been disabled ');

    }

    public function customerOrders(Request $request, Customer $customer)
    {
        
        $order = Order::latest()
        ->where('customer', '=', $customer->id)
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
    
        return view('admin.customerorders', ['orders' => $paginatedorders]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Customer $customer)
    {
        $role= 'Customer';

        Mail::send('email.accountDeletedEmail',['role' => $role], function($message) use($request){
            $email = $request->customer->email;
            $message->to($email);
            $message->subject('Deleted Account');
        }); 

        $customer->delete();

        return redirect()->route('users.index')->with('customer-message','Customer deleted successfully');
        
    }
}
