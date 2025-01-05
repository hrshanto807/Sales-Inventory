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

    function ProductDelete(Request $request){
        $user_id=$request->header('id');
        $product_id=$request->input('id');
        $filePath=$request->input('file_path');
        File::delete($filePath);
        return Product::where('id',$product_id)->where('user_id',$user_id)->delete();

       
     
    }


   
    function ProductByID(Request $request){
        $product_id=$request->input('product_id');
        $product=Product::where('id','=',$product_id)->first();
        return $product;
    }

    function ProductList(Request $request){
        $user_id=$request->header('id');
        return Product::where('user_id','=',$user_id)->get();
        
    }

    function ProductUpdate(Request $request){
        $user_id=$request->header('id');
        $product_id=$request->input('id');
        if ($request->hasFile('img')) {
            $img=$request->file('img');
            $t=time();
            $file_name=$img->getClientOriginalName();
            $img_name="{$user_id}-{$t}-{$file_name}";
            $img_url="uploads/{$img_name}";
            $img->move(public_path('uploads'),$img_name);
            $filePath=$request->input('file_path');
            File::delete($filePath);
            return Product::where('id',$product_id)->where('user_id',$user_id)->update([
                'name'=>$request->input('name'),
                'price'=>$request->input('price'),
                'unit'=>$request->input('unit'),
                'img_url'=>$img_url,
                'category_id'=>$request->input('category_id')
            ]);
        }
        else{
            return Product::where('id',$product_id)->where('user_id',$user_id)->update([
                'name'=>$request->input('name'),
                'price'=>$request->input('price'),
                'unit'=>$request->input('unit'),
                'category_id'=>$request->input('category_id')
            ]);
        }
    }

   
    
}
