<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class ProductController extends Controller
{
    function ProductPage()
    {
        return view('pages.dashboard.product-page');
    }

    function ProductCreate(Request $request)  {
        $user_id=$request->header('id');

    //    prepare file
    $img=$request->file('img');


     
    $t=time();
    $file_name=$img->getClientOriginalName();  
    $image_name="{$user_id}-{$t}-{$file_name}";    
    $img_url="uploads/{$image_name}";

    $img->move(public_path('uploads'), $image_name);

    //    save database
   try{ return Product::create([
    'name'=>$request->input('name'),
    'price'=>$request->input('price'),
    'unit'=>$request->input('unit'),
    'img_url'=>$img_url, 
    'category_id'=>$request->input('category_id'),
    'user_id'=>$user_id,
    
   ]);
}

catch(\Exception $e){return $e->getMessage();}



    }

    function ProductList(Request $request){
        $user_id=$request->header('user_id');
        $products=Product::where('user_id','=',$user_id)->get();
        return $products;
    }

    function ProductByID(Request $request){
        $product_id=$request->input('product_id');
        $product=Product::where('id','=',$product_id)->first();
        return $product;
    }

    function ProductUpdate(Request $request){
        $product_id=$request->input('product_id');
        $category_id=$request->input('category_id');
        $name=$request->input('name');
        $price=$request->input('price');
        $quantity=$request->input('quantity');
        $description=$request->input('description');
        $product=Product::where('id','=',$product_id)->update([
            'category_id'=>$category_id,
            'name'=>$name,
            'price'=>$price,
            'quantity'=>$quantity,
            'description'=>$description
        ]);
        return $product;
    }

    function ProductDelete(Request $request){
        $user_id=$request->header('id');
        $product_id=$request->input('id');
        $filePath=$request->input('file_path');
        File::delete($filePath);
        return Product::where('id',$product_id)->where('user_id',$user_id)->delete();

       
     
    }

    
}
