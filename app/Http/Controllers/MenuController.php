<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Storage;
use File;
use Image;

class MenuController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth:vendor');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $id =Auth::user()->id;

        $menus = Menu::latest()->where('vendor', '=', $id)->paginate(5, ['*'], 'menus');
        
        $categories = Category::latest()->where('vendor', '=', $id)->paginate(5, ['*'], 'categories');
        
        return view('vendor.menuindex',compact('menus','categories'));

    }
    
    public function create(category $category)
    {

        $id =Auth::user()->id;
        
        $categories = Category::get()->where('vendor', '=', $id);

        $category;

        return view('vendor.menucreate',compact('category','categories'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category' => 'required',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5000',
            'vendor' => 'required',
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

        return redirect()->route('category.viewAll', [$category])->with('message','Menu created successfully.');

    }

        /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {

        return view('vendor.menushow',compact('menu'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
    
        $id =Auth::user()->id;
        $categories = Category::get()->where('vendor', '=', $id);

        return view('vendor.menuedit',compact('menu'))->with('categories', $categories);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
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

            $menu->update(['name' => $name,
                           'description' => $description,
                           'price' => $price,
                           'category' => $category,
            ]);

            return redirect()->route('category.viewAll', [$category])->with('message','Menu updated successfully');

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

          $menu->update(['name' => $name,
                            'description' => $description,
                            'price' => $price,
                            'category' => $category,
                            'picture' => $picture_name.'.'.'webp']);

        return redirect()->route('category.viewAll', [$category])
        ->with('message','Menu Entry updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
    
        return redirect()->route('menu.index')
                        ->with('message','Menu Entry deleted successfully');
    }

    public function deleteAll(Request $request)
    {

        $id = $request->id;

        if(empty($id))
        {
            return redirect()->back()
            ->with('error-message','No entries selected');
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
		return redirect()->route('menu.index')
                        ->with('message','Menu Items deleted successfully');
        }
        return redirect()->route('menu.index')
        ->with('message','Menu Item deleted successfully');
    }
}
