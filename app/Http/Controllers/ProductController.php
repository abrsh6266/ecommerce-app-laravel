<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            return redirect('/');
        }
        return redirect("/login");
    }
    static function cartItem()
    {
        $userId = session()->get("user")["id"];
        return Cart::where("user_id", $userId)->count();
    }
    function cartList()
    {
        if (session()->has("user")) {
            $userId = session()->get("user")["id"];
            $products = DB::table("cart")
                ->join('products', 'cart.product_id', '=', 'products.id')
                ->where('cart.user_id', $userId)
                ->select('products.*', 'cart.id as cart_id')
                ->get();
            return view('cartlist', ['products' => $products]);
        }
        return redirect('/login');
    }
    function removeCart($id)
    {
        Cart::destroy($id);
        return redirect('cartlist');
    }
    function orderNow()
    {
        $userId = session()->get("user")["id"];
        $total = $products = DB::table("cart")
            ->join('products', 'cart.product_id', '=', 'products.id')
            ->where('cart.user_id', $userId)
            ->select('products.*', 'cart.id as cart_id')
            ->sum('products.price');
        return view('/ordernow', ['total'=> $total]);
    }
    function orderPlace(Request $request){
        $userId = session()->get('user')['id'];
        $allCart = Cart::where('user_id', $userId)->get();
        foreach ($allCart as $cart) {
            $order = new Order();
            $order->product_id = $cart['product_id'];
            $order->user_id = $cart['user_id'];
            $order->status = "pending";
            $order->payment_method = $request->payment;
            $order->payment_status = "pending";
            $order->address = $request->address;
            $order->save();
            Cart::where('user_id', $userId)->delete();
        }
        $request->input();
        return redirect('/') ;
    }
    function myOrders(){
        $userId = session()->get("user")["id"];
        $orders = DB::table("orders")
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where('orders.user_id', $userId)
            ->get();
        return view('/myorders', ['orders'=> $orders]);
    }
}
