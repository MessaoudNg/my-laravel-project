@extends('layouts.app')

@section('content')
@php
    $coupon_code = session('cart_coupon', null);
    $discount = session('cart_discount', 0);
@endphp

<div class="container">
    <h2 class="mb-4 text-center">🛒 سلة التسوق</h2>

    @if(count($cart) > 0)
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>الصورة</th>
                        <th>اسم المنتج</th>
                        <th>السعر</th>
                        <th>الكمية</th>
                        <th>الإجمالي</th>
                        <th>التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php $total += $item['price'] * $item['quantity']; @endphp
                        <tr data-id="{{ $id }}">
                            <td><img src="{{ asset('storage/' . $item['image']) }}" width="100" class="rounded shadow-sm"></td>
                            <td>{{ $item['name'] }}</td>
                            <td class="price">{{ number_format($item['price'], 2) }} دج</td>
                            <td><input type="number" min="1" class="form-control quantity" value="{{ $item['quantity'] }}"></td>
                            <td class="subtotal">{{ number_format($item['price'] * $item['quantity'], 2) }} دج</td>
                            <td><a href="{{ route('cart.remove', $id) }}" class="btn btn-danger btn-sm">🗑 حذف</a></td>
                        </tr>
                    @endforeach
                    <tr class="fw-bold table-light">
                        <td colspan="4">المجموع الكلي</td>
                        <td colspan="2" id="total">{{ number_format($total, 2) }} دج</td>
                    </tr>
                    <tr>
                        <td colspan="4">كود الخصم</td>
                        <td colspan="2">
                            <input type="text" id="coupon_code" class="form-control"
       value="{{ $coupon_code ?? '' }}"
       placeholder="أدخل الكوبون">

                            <button id="apply_coupon" class="btn btn-warning mt-2">💰 تطبيق الكوبون</button>
                        </td>
                    </tr>
                    <tr id="discount_row" style="{{ $discount > 0 ? '' : 'display:none;' }}">
                        <td colspan="4">الخصم</td>
                        <td colspan="2" id="discount_amount">{{ number_format($discount,2) }} دج</td>
                    </tr>
                    <tr id="grand_total_row" style="{{ $discount > 0 ? '' : 'display:none;' }}" class="fw-bold table-success">
                        <td colspan="4">المجموع بعد الخصم</td>
                        <td colspan="2" id="grand_total">{{ number_format($total - $discount,2) }} دج</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ url('/') }}" class="btn btn-outline-primary">⬅️ متابعة التسوق</a>
            <a href="{{ route('cart.clear') }}" class="btn btn-outline-danger">🧹 تفريغ السلة</a>
            <a href="{{ route('checkout') }}" class="btn btn-success">💳 إتمام الشراء</a>
        </div>
    @else
        <div class="alert alert-info text-center">
            🛍️ السلة فارغة حالياً، أضف بعض المنتجات من <a href="{{ url('/') }}">الصفحة الرئيسية</a>.
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // تحديث الكمية مباشرة
    $('.quantity').on('change', function() {
        var row = $(this).closest('tr');
        var id = row.data('id');
        var qty = $(this).val();

        $.ajax({
            url: "{{ route('cart.update') }}",
            method: 'POST',
            data: {_token: "{{ csrf_token() }}", id: id, quantity: qty},
            success: function(data) {
                row.find('.subtotal').text(data.subtotal + ' دج');
                $('#total').text(data.total + ' دج');
                if($('#discount_row').is(':visible')) {
                    applyCoupon($('#coupon_code').val());
                }
            }
        });
    });

    // تطبيق الكوبون
    $('#apply_coupon').on('click', function() {
        applyCoupon($('#coupon_code').val());
    });

    function applyCoupon(code) {
        if(code === '') return;
        $.ajax({
            url: "{{ route('cart.coupon') }}",
            method: 'POST',
            data: {_token: "{{ csrf_token() }}", code: code},
            success: function(data) {
                if(data.valid) {
                    $('#discount_row').show();
                    $('#discount_amount').text(data.discount + ' دج');
                    $('#grand_total_row').show();
                    $('#grand_total').text(data.total_after_discount + ' دج');
                    alert('تم تطبيق الكوبون بنجاح!');
                } else {
                    alert('الكوبون غير صالح');
                    $('#discount_row').hide();
                    $('#grand_total_row').hide();
                }
            }
        });
    }
});
</script>
@endsection
