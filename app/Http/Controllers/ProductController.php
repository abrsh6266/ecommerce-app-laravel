<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function index()
    {
        $products = Product::all();
        return view("product", ["products" => $products]);
    }
    function detail($id)
    {
        $product = Product::find($id);
        return view("detail", ["product" => $product]);
    }
    function addToCart(Request $request)
    {
        if ($request->session()->has("user")) {
            $cart = new Cart;
            $cart->user_id = $request->session()->get("user")["id"];
            $cart->product_id = $request->product_id;
            $cart->save();
            return redirect('/') ;
        }
        return redirect("/login");
    }
    static function cartItem(){
        $userId = session()->get("user")["id"];
        return Cart::where("user_id", $userId)->count();
    }
}
