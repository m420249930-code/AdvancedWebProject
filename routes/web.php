<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', function () {
    $products = DB::table('products')->latest()->get();

    return view('products', compact('products'));
});

Route::post('/products', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
    ]);

    DB::table('products')->insert([
        'name' => $validated['name'],
        'price' => $validated['price'],
        'quantity' => $validated['quantity'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect('/products')->with('success', 'Product added successfully!');
});
