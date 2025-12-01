<!DOCTYPE html>
<html>
<head>
    <title>إضافة منتج</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h1>➕ إضافة منتج جديد</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>اسم المنتج</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>الوصف</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>السعر</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>صورة المنتج</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button class="btn btn-success">حفظ</button>
    </form>
</body>
</html>
