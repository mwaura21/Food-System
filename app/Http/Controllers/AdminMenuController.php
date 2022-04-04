<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Storage;
use File;
use Image;

class AdminMenuController extends Controller
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
    public function viewMenu(Vendor $vendor)
    {

        $vendor = $vendor->id;
        $menus = Menu::latest()->where('vendor', '=', $vendor)->paginate(5, ['*'], 'menus');
        $categories = Category::latest()->where('vendor', '=', $vendor)->paginate(5, ['*'], 'categories');
        
        return view('admin.menumore',compact('menus','categories', 'vendor'));

    }

    public function index()
    {

        $vendors = Vendor::latest()->paginate(5);
        
        return view('admin.menuindex',compact('vendors'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(category $category,Vendor $vendor)
    {

        $vendor = $vendor->id;
        $categories = Category::get()->where('vendor', '=', $vendor);
        $category;

        return view('admin.menucreate',compact('category','categories', 'vendor'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([

            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category' => 'required',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5000',

        ]);

        $request_picture = $request->file('picture');
        $picture = Image::make($request_picture);
        $picture_path = public_path().'\storage\images\\';

        if (!File::exists($picture_path)) 
        {

            File::makeDirectory($picture_path);

        }

        $picture_name = time();
        $w = $picture->width();
        $h = $picture->height();

        if($w > $h) 
        {

            $picture->resize(400, null, function ($constraint) 
            {
                $constraint->aspectRatio();
            });
            
        } 
        
        else 
        {

            $picture->resize(null, 400, function ($constraint) 
            {
                $constraint->aspectRatio();
            });

        }
        
        $picture->orientate();

        $picture->save($picture_path.$picture_name.'.webp');

        $date = $request->input('date'); 
        
        Menu::create([
            'name' => ($request->name),
            'description' => ($request->description),
            'price' => ($request->price),
            'category' => ($request->category),
            'picture' => ($picture_name.'.'.'webp'),
            'vendor' => ($request->vendor),
        ]);

        $category = $request->input('category');

        return redirect()->route('scategory.viewAll', [$category])->with('message','Menu created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {

        return view('admin.menushow',compact('menu'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $smenu, Vendor $vendor)
    {
    
        $vendor = $vendor->id;
        $categories = Category::get()->where('vendor', '=', $vendor);

        return view('admin.menuedit',compact('smenu'))->with('categories', $categories);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $smenu)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category' => 'required',
            'picture' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:5000',
        ]);

        if(is_null($request->picture))
        {

            $name = $request->input('name');
            $description = $request->input('description');  
            $price = $request->input('price');  
            $category = $request->input('category');  

  
            $smenu->update(['name' => $name,
                            'description' => $description,
                            'price' => $price,
                            'category' => $category,
            ]);

            return redirect()->route('scategory.viewAll', [$category])->with('message','Menu updated successfully');

        }

        unlink('C:/Users/Admin/ISproject/public/storage/images/'.$request->old_picture);

        $request_picture = $request->file('picture');
        $picture = Image::make($request_picture);
        $picture_path = public_path().'\storage\images\\';

        if (!File::exists($picture_path)) 
        {

            File::makeDirectory($picture_path);

        }

        $picture_name = time();

        $w = $picture->width();
        $h = $picture->height();

        if($w > $h) 
        {

            $picture->resize(500, null, function ($constraint) 
            {
                $constraint->aspectRatio();
            });

        } 

        else 
        
        {
            $picture->resize(null, 500, function ($constraint) 
            {
                $constraint->aspectRatio();
            });

        }
        
        $picture->orientate();

        $picture->save($picture_path.$picture_name.'.webp');

        $name = $request->input('name');
        $description = $request->input('description');  
        $price = $request->input('price');  
        $category = $request->input('category');  

        $smenu->update(['name' => $name,
                        'description' => $description,
                        'price' => $price,
                        'category' => $category,
                        'picture' => $picture_name.'.'.'webp']);

        return redirect()->route('scategory.viewAll', [$category])->with('message','Menu Entry updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
    }

    public function deleteAll(Request $request)
    {

        $id = $request->id;

        if(empty($id))
        {

            return redirect()->back()->with('error-message','No entries selected');

        }

        $n = sizeof($id);

        for( $i=0 ; $i < $n ; $i++) 
        {

            $picture_id = $id[$i];
            unlink('C:/Users/Admin/ISproject/public/storage/images/'.$picture_id);

            Menu::where('picture', $picture_id)->delete();

        }

        if($n > 1)
        {
            
            return redirect()->route('scategory.viewAll', [$request->category])->with('message','Menu Items deleted successfully');

        }

        return redirect()->route('scategory.viewAll', [$request->category])->with('message','Menu Item deleted successfully');

    }
}
