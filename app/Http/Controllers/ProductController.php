<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function index(){
        $products = Product::all();
        return view("product",["products"=>$products]);
    }
    function detail($id){
        $product = Product::find($id);
        return view("detail",["product"=>$product]);
    } 
}
