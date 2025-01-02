<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function CategoryPage(){
        return view('page.dashboard.category-page');
    }

   function CategoryList(Request $request){

    return  Category::where('user_id',$request->header('id'))->get();
       
   }

   function CategoryCreate(Request $request){

    $name=$request->input('name');
    $user_id=$request->header('id');
    return Category::create([
        'name'=>$name,
        'user_id'=>$user_id
    ]);
   }

   function CategoryUpdate(Request $request){
    $id=$request->input('id');
    $user_id=$request->header('id');
    $name=$request->input('name');
    return Category::where('id',$id)->where('user_id',$user_id)->update([
        'name'=>$name
    ]);
   }

   function CategoryDelete(Request $request){
    $id=$request->input('id');
    $user_id=$request->header('id');
    return Category::where('id',$id)->where('user_id',$user_id)->delete();
   }

    // function CategoryDelete(){
    //     return view('components.category.category-delete');
    // }

    // function CategoryCreate(){
    //     return view('components.category.category-create');
    // }

    // function CategoryUpdate(){
    //     return view('components.category.category-update');
    // }

    // function CategoryList(){
    //     return view('components.category.category-list');
    // }
}