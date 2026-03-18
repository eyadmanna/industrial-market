<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>لوحة التحكم - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: 250px;
            background: linear-gradient(180deg, #0b2f5e, #071b2f);
            color: white;
            padding: 20px 0;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.8);
            padding: 12px 20px;
            margin: 2px 0;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,.1);
        }
        .sidebar .nav-link i {
            margin-left: 10px;
        }
        .content {
            margin-right: 250px;
            padding: 20px;
        }
        .navbar-top {
            background: white;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,.1);
            margin-bottom: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                right: -250px;
                transition: .3s;
            }
            .sidebar.show {
                right: 0;
            }
            .content {
                margin-right: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="text-center mb-4">
            <img src="{{ asset('assets/logo.svg') }}" alt="" width="50">
            <h5 class="mt-2">لوحة التحكم</h5>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> الرئيسية
            </a>
            <a class="nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}"
                href="{{ route('admin.sliders.index') }}">
                <i class="bi bi-images"></i> السلايدر
            </a>
            <a class="nav-link {{ request()->routeIs('admin.sections.*') ? 'active' : '' }}"
               href="{{ route('admin.sections.index') }}">
                <i class="bi bi-grid-3x3-gap-fill"></i> الأقسام
            </a>
            <a class="nav-link {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}"
               href="{{ route('admin.gallery.index') }}">
                <i class="bi bi-images"></i> معرض الصور
            </a>
            <a class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}"
               href="{{ route('admin.contacts.index') }}">
                <i class="bi bi-envelope"></i> الرسائل
                @php $unread = \App\Models\Contact::where('is_read', false)->count(); @endphp
                @if($unread > 0)
                    <span class="badge bg-danger">{{ $unread }}</span>
                @endif
            </a>
            <a class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}"
               href="{{ route('admin.settings') }}">
                <i class="bi bi-gear"></i> الإعدادات
            </a>
            <a class="nav-link" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i> تسجيل خروج
            </a>
        </nav>
    </div>

    <div class="content">
        <div class="navbar-top d-flex justify-content-between align-items-center">
            <button class="btn btn-outline-secondary d-md-none" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <div>
                مرحباً، {{ Auth::user()->name }}
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }
    </script>
    @stack('scripts')
</body>
</html>
