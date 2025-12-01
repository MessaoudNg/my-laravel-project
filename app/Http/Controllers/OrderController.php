<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedMail;

class OrderController extends Controller
{
    // صفحة إتمام الطلب
public function checkout()
{
    $cart = session()->get('cart', []);
    if(count($cart) === 0){
        return redirect('/')->with('error', 'السلة فارغة');
    }

    // المجموع الكلي الأصلي
    $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

    // جلب الخصم والكوبون من الجلسة
    $discount = session('cart_discount', 0);
    $coupon_code = session('cart_coupon', null);

    // المجموع بعد الخصم
    $total_after_discount = max(0, $total - $discount);

    // إرسال كل القيم للـ Blade
    return view('checkout', compact('cart', 'total', 'discount', 'coupon_code', 'total_after_discount'));
}

    // حفظ الطلب
  public function placeOrder(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:100',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'email' => 'nullable|email',
    ]);

    $cart = session()->get('cart', []);
    if (count($cart) === 0) {
        return redirect('/')->with('error', 'السلة فارغة');
    }

    $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    $discount = session('cart_discount', 0);
    $coupon_code = session('cart_coupon', null);
    $total_after_discount = max(0, $total - $discount);

    $order = Order::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
        'total' => $total_after_discount,
        'discount' => $discount,
        'coupon_code' => $coupon_code,
        'items' => json_encode($cart),
    ]);

    // إرسال البريد للعميل
    if($order->email){
        Mail::to($order->email)->send(new OrderPlacedMail($order));
    }

    // مسح السلة
    session()->forget(['cart', 'cart_discount', 'cart_coupon']);

    return redirect('/')->with('success', '✅ تم إرسال طلبك بنجاح!');
}


    // عرض جميع الطلبات في لوحة الإدارة
    public function adminIndex()
    {
        $orders = Order::all();
        foreach ($orders as $order){
            $order->items = json_decode($order->items,true);
        }
        return view('admin.orders.index', compact('orders'));
    }

    // حذف طلب
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', '✅ تم حذف الطلب بنجاح!');
    }

    // تأكيد الطلب كمكتمل
    public function complete(Order $order)
    {
        $order->update(['status' => 'مكتمل']);
        return redirect()->back()->with('success', '✅ تم تأكيد الطلب كمكتمل!');
    }
}
