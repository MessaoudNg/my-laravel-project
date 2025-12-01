<h2>شكرًا لطلبك، {{ $order->name }}!</h2>
<p>تم استلام طلبك بنجاح. إليك ملخص الطلب:</p>
<ul>
    @foreach(json_decode($order->items, true) as $item)
        <li>{{ $item['name'] }} - {{ $item['quantity'] }} × {{ $item['price'] }} دج</li>
    @endforeach
</ul>
<p>المجموع: {{ $order->total }} دج</p>
@if($order->discount > 0)
<p>الخصم: {{ $order->discount }} دج (كود: {{ $order->coupon_code }})</p>
@endif
<p>العنوان: {{ $order->address }}</p>
<p>رقم الهاتف: {{ $order->phone }}</p>

