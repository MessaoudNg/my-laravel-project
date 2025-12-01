<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // عرض جميع المنتجات في واجهة المستخدم
    public function showProducts()
    {
        $products = Product::all();
        return view('products.list', compact('products'));
    }

    public function show($id)
{
    $product = Product::findOrFail($id);
    return view('products.show', compact('product'));
}

}
