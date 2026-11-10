<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

// عرض المنتجات
Route::get('/products', function () {
    $products = DB::table('products')->latest()->get();

    return view('products', compact('products'));
});

// إضافة منتج
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

    return redirect('/products')
        ->with('success', 'Product added successfully!');
});

// فتح فورم التعديل
Route::post('/products/edit/{id}', function ($id) {
    $editingProduct = DB::table('products')
        ->where('id', $id)
        ->first();

    abort_if(!$editingProduct, 404);

    $products = DB::table('products')->latest()->get();

    return view('products', compact('products', 'editingProduct'));
});

// حفظ التعديلات
Route::post('/products/update', function (Request $request) {
    $validated = $request->validate([
        'id' => 'required|integer|exists:products,id',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
    ]);

    DB::table('products')
        ->where('id', $validated['id'])
        ->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'updated_at' => now(),
        ]);

    return redirect('/products')
        ->with('success', 'Product updated successfully!');
});

// حذف منتج
Route::post('/products/delete/{id}', function ($id) {
    DB::table('products')->where('id', $id)->delete();

    return redirect('/products')
        ->with('success', 'Product deleted successfully!');
});
