@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">💳 إتمام الطلب</h2>

    <form action="{{ route('order.place') }}" method="POST" class="card p-4 shadow">
        @csrf
        <div class="mb-3">
            <label class="form-label">الاسم الكامل</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">البريد الإلكتروني (اختياري)</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">رقم الهاتف</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">العنوان الكامل</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>

        <div class="alert alert-info text-center">
    💰 المجموع الكلي: <strong>{{ number_format($total_after_discount, 2) }} دج</strong>
</div>

@if($discount > 0)
<div class="alert alert-success text-center">
    🏷️ الكوبون: <strong>{{ $coupon_code }}</strong> - خصم: <strong>{{ number_format($discount,2) }} دج</strong>
</div>
@endif

        <button type="submit" class="btn btn-success w-100">✅ تأكيد الطلب</button>
    </form>
</div>
@endsection
