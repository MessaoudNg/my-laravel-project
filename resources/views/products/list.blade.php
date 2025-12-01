@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4 text-primary fw-bold">🛍️ منتجاتنا</h2>

    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/250" class="card-img-top" alt="no image">
                @endif
                <div class="card-body">
                    <h5 class="card-title text-center text-dark">{{ $product->name }}</h5>
                    <p class="card-text text-muted small">{{ Str::limit($product->description, 100) }}</p>
                    <p class="fw-bold text-center text-success fs-5">{{ $product->price }} دج</p>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="{{ route('cart.add', $product->id) }}" class="btn btn-primary w-100">
                        🛒 أضف إلى السلة
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
