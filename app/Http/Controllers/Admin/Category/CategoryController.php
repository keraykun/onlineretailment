<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;
class CategoryController extends Controller
{
    public function index(Request $request){
        if($request->search){
            $search = $request->search;
            $categories = Categories::where('name','like',"%$search%")->paginate(10);
        }else{
            $categories = Categories::paginate(10);
        }
        return view('admin.category.index',['categories'=>$categories]);
    }

    public function create(Request $request){
        Categories::create(['name'=>$request->category]);
        return redirect()->back()->with('success','Category Added');
    }

    public function destroy(Categories $category){
        Categories::destroy($category->id);
        return redirect()->back()->with('danger',$category->name.' has been Deleted!');
    }

    public function update(Request $request){
        Categories::where('_id',$request->id)->update(['name'=>$request->category]);
        return redirect()->back()->with('info',$request->category.' has been Updated!');
     }
}
