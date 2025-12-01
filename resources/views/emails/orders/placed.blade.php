@component('mail::message')
# مرحباً {{ $order->name }}

لقد تم استلام طلبك بنجاح.  

**تفاصيل الطلب:**

@foreach(json_decode($order->items, true) as $item)
- {{ $item['name'] }} x {{ $item['quantity'] }} = {{ number_format($item['price'] * $item['quantity'], 2) }} دج
@endforeach

**المجموع بعد الخصم:** {{ number_format($order->total, 2) }} دج  
@if($order->discount > 0)
**الخصم:** {{ number_format($order->discount, 2) }} دج  
**كود الكوبون:** {{ $order->coupon_code }}  
@endif

شكراً لاستخدامك موقعنا!

@endcomponent
