<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\County;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth:customer');

    }
    /**
     * show dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('customer');

    }

    public function menu(Vendor $vendor)
    {

        $menus = Menu::latest()->where('vendor', '=', $vendor->id)->paginate(5);

        return view('customer.menuindex', compact('menus'));
    }

    public function vendor()
    {

        $vendors = Vendor::all();

        return view('customer.vendorlist', compact('vendors'));
    }

    public function cart()
    {

        return view('customer.cart');

    }

    public function myorders(Request $request)
    {

        $id =Auth::user()->id;

        $order = Order::latest()
            ->where('customer', '=', $id)
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
    
        return view('customer.orders', ['orders' => $paginatedorders]);
        
    }

    public function paginate($items, $perPage = 1, $page = null, $options = [])
    {

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    public function order(Request $request)
    {

        $request->validate([
            'vendor' => 'required',
            'customer' => 'required',
            'name' => 'required',
            'picture' => 'required',
            'one_total' => 'required',
            'quantity' => 'required',
            'total' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'county' => 'required',
            'payment' => 'required', 
        ]);

        $input = $request->all();
        $counts = $input['counts'];
        $vendors = $input['vendor'];
        $names = $input['name'];
        $pictures = $input['picture'];
        $one_totals = $input['one_total'];
        $quantity = $input['quantity'];

        $arraye = array($names, $pictures, $vendors, $quantity, $one_totals);
        $randomNumber = random_int(100000, 999999);
        $n = sizeof($counts);

        for( $i=0 ; $i < $n ; $i++) 
        {

            Order::create([
                'order_id' => ($randomNumber),
                'vendor' => ($vendors[$i]),
                'customer' => (Auth::user()->id),
                'name' => ($names[$i]),
                'first_name' => ($request->first_name),
                'last_name' => ($request->last_name),
                'email' => ($request->email),
                'phone_number' => ($request->phone_number),
                'picture' => ($pictures[$i]),
                'address' => ($request->address),
                'county' => ($request->county ),
                'payment' => ($request->payment),
                'quantity' => ($quantity[$i]),
                'quantity' => ($quantity[$i]),
                'one_total' => ($one_totals[$i]),
                'total' => ($request->total)
            ]);

        }

        session()->forget('cart');

        return redirect()->route('customer.dashboard')->with('message','Order made successfully');
     
    }

    public function addToCart($id)
    {

        $menu = Menu::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) 
        {

            $cart[$id]['quantity']++;

        } 
        else 
        {

            $cart[$id] = [
                "name" => $menu->name,
                "quantity" => 1,
                "description" =>$menu->description,
                "price" => $menu->price,
                "picture" => $menu->picture,
                "customer" => Auth::user()->id,
                "first_name" => Auth::user()->first_name , 
                "last_name" => Auth::user()->last_name ,
                "vendor" => $menu->vendor,
            ];

        }

        session()->put('cart', $cart);

        return redirect()->back()->with('message', 'Menu item added to cart successfully!');

    }

    public function checkout()
    {

        $menus = Menu::all();
        $carts = session()->get('cart', []);
        
        if($carts == null)
        {

            return redirect()->route('menu')->with('error-message', 'Your cart is empty, add items to checkout');

        }

        $counties = County::get();

        return view('customer.checkout')->with(compact(['carts', 'counties']));

    }

    public function update(Request $request)
    {

        if($request->id && $request->quantity)
        {

            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('message', 'Cart updated successfully');

        }
    }

    public function remove(Request $request)
    {
        if($request->id) 
        {

            $cart = session()->get('cart');

            if(isset($cart[$request->id])) 
            {

                unset($cart[$request->id]);
                session()->put('cart', $cart);

            }

            session()->flash('message', 'Item removed successfully');

        }
    }

    public function showupdateform()
    {

        $counties = County::get();

        return view('customer.update_profile')->with('counties', $counties);

    }

    public function updateprofile(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'counties' => 'required',
            'phone_number' => 'required',
        ]);

        $current_user = Auth::user();
        $current_user->first_name = $request->get('first_name');
        $current_user->last_name = $request->get('last_name');
        $current_user->counties = $request->get('counties');
        $current_user->phone_number = $request->get('phone_number');

        $current_user->update();
      
        return redirect()->route('customer.dashboard')->with('message','Account updated successfully');
    }
}