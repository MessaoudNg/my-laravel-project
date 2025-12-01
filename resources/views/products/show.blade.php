@extends('layouts.app')

@section('content')
<div class="card mx-auto shadow-lg" style="max-width: 700px;">
    @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
    @endif
    <div class="card-body text-center">
        <h2 class="card-title">{{ $product->name }}</h2>
        <p class="card-text mt-3">{{ $product->description }}</p>
        <h4 class="text-success mt-3">{{ $product->price }} دج</h4>

        <a href="{{ route('cart.add', $product->id) }}" class="btn btn-primary mt-3">🛒 أضف إلى السلة</a>
        <a href="{{ url('/') }}" class="btn btn-outline-secondary mt-3">⬅️ الرجوع</a>
    </div>
</div>
@endsection
