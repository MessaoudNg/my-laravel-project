<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>🏪 السوق الإلكتروني</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="text-center mb-4">🛍️ منتجاتنا</h1>

    <div class="row">
        @foreach($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($product->description, 60) }}</p>
                        <p class="fw-bold text-success">{{ $product->price }} دج</p>
                        <a href="{{ route('cart.add', $product->id) }}" class="btn btn-primary w-100">🛒 أضف إلى السلة</a>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>
