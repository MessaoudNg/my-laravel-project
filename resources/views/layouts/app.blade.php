<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'المتجر الإلكتروني' }}</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Cairo', sans-serif;
        }
        .navbar {
            background-color: #0d6efd;
        }
        .navbar a {
            color: white !important;
        }
        .card img {
            height: 220px;
            object-fit: cover;
        }
        footer {
            margin-top: 50px;
            background-color: #0d6efd;
            color: white;
            text-align: center;
            padding: 15px 0;
        }
    </style>
</head>
<body>

    <!-- 🔹 شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">🛍️ متجر إلكتروني</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">

                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ url('/') }}">🏠 الصفحة الرئيسية</a>
                    </li>

                    <!-- 🛒 السلة -->
                    <li class="nav-item position-relative">
                        <a class="nav-link fw-bold" href="{{ route('cart.index') }}">
                            🛒 السلة
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                                    {{ count(session('cart')) }}
                                </span>
                            @endif
                        </a>
                    </li>

                    <!-- 🗑️ زر تفريغ السلة -->
                    @if(session('cart') && count(session('cart')) > 0)
                        <li class="nav-item">
                            <a class="nav-link fw-bold text-danger"
                               href="{{ route('cart.clear') }}"
                               onclick="return confirm('هل تريد تفريغ السلة بالكامل؟')">
                                🗑️ تفريغ السلة
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ url('/admin/products') }}">⚙️ لوحة التحكم</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('admin.orders.index') }}">📦 الطلبات</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- ✅ عرض رسائل النجاح -->
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    <footer>
        <p>© {{ date('Y') }} جميع الحقوق محفوظة | مشروع تسويق إلكتروني جامعي</p>
    </footer>

    <!-- ✅ سكربتات -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- ✅ مكتبات التصدير -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            if ($('#ordersTable').length) {
                $('#ordersTable').DataTable({
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/ar.json"
                    },
                    pageLength: 5,
                    order: [[0, "desc"]],
                    dom: 'Bfrtip',
                    buttons: [
                        { extend: 'excelHtml5', text: '📊 Excel', className: 'btn btn-success btn-sm' },
                        { extend: 'pdfHtml5', text: '📄 PDF', className: 'btn btn-danger btn-sm' },
                        { extend: 'print', text: '🖨️ طباعة', className: 'btn btn-primary btn-sm' }
                    ]
                });
            }
        });
    </script>

    @yield('scripts')

</body>
</html>
