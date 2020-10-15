<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function manager()
    {
        $cats = Category::orderBy('id', 'desc')->paginate(5);
//        $cats = Category::orderBy('id', 'desc');
//        dd($cats);
        return view('admin.category.category')->with(compact('cats'));
    }
    public function create()
    {
        return view('admin.category.create_category');
    }

    public function store(Request $request)
    {
        $cat = new Category($request->all());
        $cat->save();
        return response()->json();
    }
    public function edit($id)
    {
        $cat = Category::find($id);
        return view('admin.category.edit.category')->with(compact('cat'));
    }

    public function update(Request $request, $id)
    {
        $cat = Category::find($id);
        $cat->fill($request->all());
        $cat->save();
        return response()->json(['cat' => $cat]);
    }
    public function delete($id)
    {
        $cat = Category::find($id);
        $cat->delete();
        return redirect()->route('category.manager');
    }

}

//    public function store(Request $request)
//    {
//        $validator = Validator::make($request->all(),[
//            'title' => 'required|min:5',
//        ]);
////
//        if($validator->passes())
//        {
//            $category = new Category($request->all());
//            $category->save();
//            return response()->json(['success'=>'inserted category successfully']);
//        }
////
//        return response()->json(['error'=>$validator->errors()->all()]);
////        $validate = $this->validate($request,[
////           'title' => 'required'
////        ]);
////
////        dd($validate);
////
////        $category = new Category($request->all());
////        $category->save();
////        return response()->json(['success'=>'inserted data']);
////        return redirect()->route('admin.category');
//    }