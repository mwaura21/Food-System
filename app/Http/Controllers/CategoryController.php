<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class CategoryController extends Controller
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

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('vendor.menucreate');

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
            'vendor' => 'required'
        ]);
    
        Category::create($request->all());
     
        return redirect()->route('menu.index')->with('message','Category created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

        return view('vendor.menushow',compact('category','menu'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {

        return view('vendor.menuedit',compact('category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

        $request->validate([
            'name' => 'required',
        ]);
    
        $category->update($request->all());
    
        return redirect()->route('menu.index')
                        ->with('message','Category updated successfully');

    }

    public function viewAll(Request $request, Category $category)
    {

        $menus = Menu::latest()->where('category', $category->id)->paginate(5);
        $category;

        return view('vendor.menuview',compact('menus', 'category'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {

        $category->delete();
    
        return redirect()->route('menu.index')->with('category-message','Category deleted successfully');

    }

    public function deleteAll(Request $request)
    {

		$id = $request->id;
        if(empty($id))
        {

            return redirect()->back()->with('error-message','No entries selected');

        }
		foreach ($id as $menu) 
		{

            $number = count($id);

			Category::where('id', $menu)->delete();

		}
        if($number > 1)
        {

		    return redirect()->route('menu.index')->with('message','Categories deleted successfully');

        }

        return redirect()->route('menu.index')->with('message','Category deleted successfully');
        
    }
}
