<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // قائمة الكوبونات التجريبية
    private $coupons = [
        'DISCOUNT10' => 10,
        'SAVE50' => 50,
    ];

    // عرض محتوى السلة
    public function index()
    {
        $cart = session()->get('cart', []);
        $discount = session('cart_discount', 0);
        $coupon_code = session('cart_coupon', null);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $total_after_discount = max(0, $total - $discount);

        return view('site.cart', compact('cart', 'total', 'discount', 'coupon_code', 'total_after_discount'));
    }

    // إضافة منتج للسلة
    public function add(Product $product)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$product->id])){
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'تمت إضافة المنتج إلى السلة 🛒');
    }

    // حذف منتج من السلة
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])){
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('success', 'تم تعديل السلة 🧺');
    }

    // تفريغ السلة
    public function clear()
    {
        session()->forget(['cart','cart_discount','cart_coupon']);
        return redirect()->route('cart.index')->with('success', 'تم تفريغ السلة 🧺');
    }

    // تحديث الكمية
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->id;
        $quantity = max(1, intval($request->quantity));

        if(isset($cart[$id])){
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);

            $subtotal = $cart[$id]['price'] * $cart[$id]['quantity'];
            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

            $discount = session('cart_discount', 0);
            $total_after_discount = max(0, $total - $discount);

            return response()->json([
                'subtotal' => number_format($subtotal, 2),
                'total' => number_format($total, 2),
                'total_after_discount' => number_format($total_after_discount, 2)
            ]);
        }

        return response()->json(['error' => 'المنتج غير موجود'], 404);
    }

    // تطبيق الكوبون
   public function coupon(Request $request)
{
    $code = strtoupper(trim($request->code));
    $cart = session()->get('cart', []);
    $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

    $coupons = [
        'DISCOUNT10' => 10,
        'SAVE50' => 50,
    ];

    if(isset($coupons[$code])) {
        $discount = $coupons[$code];
        $total_after_discount = max(0, $total - $discount);

        // ✅ حفظ الكوبون والخصم في الجلسة
        session(['cart_discount' => $discount]);
        session(['cart_coupon' => $code]);

        return response()->json([
            'valid' => true,
            'discount' => number_format($discount, 2),
            'total_after_discount' => number_format($total_after_discount, 2)
        ]);
    }

    return response()->json(['valid' => false]);
}

}
