<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Vendor;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
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
    public function create(Vendor $vendor)
    {

        return view('admin.menucreate',compact('vendor'));

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
     
        return redirect()->route('smenu.vendor', [$request->vendor])->with('message','Category created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

        return view('admin.menushow',compact('category','menu'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $scategory)
    {

        return view('admin.menuedit',compact('scategory'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $scategory)
    {

        $request->validate([
            'name' => 'required',
        ]);

        $scategory->update($request->all());

        return redirect()->route('smenu.vendor', [$scategory->vendor])->with('message','Category updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */

    public function viewAll(Request $request, Category $category)
    {

        $menus = Menu::latest()->where('category', $category->id)->paginate(5);
        $category;

        return view('admin.menuview',compact('menus', 'category'));

    }

    public function deleteAll(Request $request, Vendor $vendor)
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

        return redirect()->route('smenu.vendor', [$request->vendor])->with('message','Categories deleted successfully');

        }

        return redirect()->route('smenu.vendor', [$request->vendor])->with('message','Category deleted successfully');
        
    }

    public function destroy(Category $category)
    {
        //
    }
}
