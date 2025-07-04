<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // dd(session('cart')); 
        $cartItems = session('cart', []);

        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'];
        }

        return view('pages.cart.index', compact('cartItems', 'totalPrice'));
    }
}