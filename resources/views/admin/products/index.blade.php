<!DOCTYPE html>
<html>
<head>
    <title>لوحة التحكم - المنتجات</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h1>📦 قائمة المنتجات</h1>
    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">➕ إضافة منتج</a>

   <table class="table table-bordered">
    <tr>
        <th>الصورة</th>
        <th>الاسم</th>
        <th>السعر</th>
        <th>الوصف</th>
        <th>التحكم</th>
    </tr>
    @foreach($products as $product)
    <tr>
        <td>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" width="80">
            @else
                لا توجد صورة
            @endif
        </td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->price }} دج</td>
        <td>{{ $product->description }}</td>
        <td>
            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">تعديل</a>
            <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline-block;">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm">حذف</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

</body>
</html>
