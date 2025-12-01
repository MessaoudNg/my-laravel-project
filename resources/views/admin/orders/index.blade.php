@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">📦 قائمة الطلبات</h2>

    <div class="table-responsive">
        <table id="ordersTable" class="table table-hover table-bordered text-center align-middle">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>👤 الاسم</th>
                    <th>📧 البريد</th>
                    <th>📞 الهاتف</th>
                    <th>📍 العنوان</th>
                    <th>💰 المجموع</th>
                    <th>🛍️ المنتجات</th>
                    <th>📅 التاريخ</th>
                    <th>الحالة</th>
                    <th>التحكم</th>
                </tr>
            </thead>

            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ number_format($order->total, 2) }} دج</td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                @foreach($order->items as $item)
                                    <li>{{ $item['name'] }} (x{{ $item['quantity'] }}) - {{ number_format($item['price'], 2) }} دج</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <span class="badge {{ $order->status === 'مكتمل' ? 'bg-success' : 'bg-warning' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td>
                            @if($order->status !== 'مكتمل')
                                <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">✔️ مكتمل</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد حذف هذا الطلب؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑 حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
