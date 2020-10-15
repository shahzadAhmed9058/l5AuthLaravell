<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Category;
use App\Admin\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function manager()
    {
        $subcats = SubCategory::orderBy('id','desc')->paginate(5);
//        $subcats = SubCategory::all();
        return view('admin.sub-category.subcategory')->with(compact('subcats'));
    }
    public function create()
    {
        $cats = Category::all();
        return view('admin.sub-category.create_subcategory')->with(compact('cats'));
    }
    public function store(Request $request)
    {
        $subcat = new SubCategory($request->all());
        $subcat->save();
        return redirect()->back();
//        return response()->json(['title' => $subcat->title ,'message' => 'inserted successfully']);
    }
    public function edit($id)
    {
        $subcat = SubCategory::find($id);
        return view('admin.subcategory.edit_subcategory')->with(compact('subcat'));
    }

    public function update(Request $request, $id)
    {
        $subcat = SubCategory::find($id);
        $subcat->fill($request->all());
        $subcat->save();
        return response()->json(['subcat' => $subcat]);
    }
    public function delete($id)
    {
        $subcat = SubCategory::find($id);
        $subcat->delete();
        return redirect()->route('subcategory.manager');
    }

}

