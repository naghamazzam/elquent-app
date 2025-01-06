<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //fetch all data from the database
    public function get_all(){
        //return 'ok';
        $products = Product::all();
        return response() -> json([
            'Products' => $products ,
            'msg' => 'Get all products successfully'
        ]);
    }

    //create a new product in the database
    public function create(Request $request){
        //return $request;
        $product = Product::create([
            // DB column => value
            // mass assignment -------------------------------------------------------------
            'name' => $request->name ,
            'description' => $request->description ,
            'price' => $request->price
        ]);
        /*
        don't use
        $product = Product::create([$request->all()]);
        to not interrupt or huck you
        */
        return $product;
        /*return the object (inserted product)
        return record(obj)*/
    }

    //show product in database
    public function show(Request $request , $id){
        $product = Product::find($id);
        return $product;
    }

    public function show_2(Request $request){
        $product = Product::find($request->id);
        return $product;
    }

    //update a product in the database
    public function update(Request $request , $id){
        //return 'ok';
        $product = Product::find($id);
        $product->update([
            'name' => $request->name ,
            'description' => $request->description ,
            'price' => $request->price
        ]);
        return $product;
    }

    public function apdate(Request $request){
        //return 'ok';
        $product = Product::find($request->id);
        $product->update([
            'name' => $request->name ,
            'description' => $request->description ,
            'price' => $request->price
        ]);
        return $product;
    }

    public function delete(Request $request){
        //return ' ok';
        $product = Product::destroy($request->id);
        return response()->json([
            'delete or not' => $product ,
            'msg' => 'The product '.$request->id.' is successfully deleted'
        ]);
    }

}
