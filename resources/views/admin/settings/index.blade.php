@extends('admin.layouts.admin')

@section('title', 'الإعدادات')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">إعدادات الموقع</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">رقم الجوال</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                               value="{{ $settings['phone'] }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="{{ $settings['email'] }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">العنوان</label>
                    <input type="text" class="form-control" id="address" name="address"
                           value="{{ $settings['address'] }}" required>
                </div>

                <div class="mb-3">
                    <label for="working_hours" class="form-label">ساعات العمل</label>
                    <input type="text" class="form-control" id="working_hours" name="working_hours"
                           value="{{ $settings['working_hours'] }}" required>
                </div>

                <div class="mb-3">
                    <label for="map_location" class="form-label">موقع الخريطة (جزء الـ URL)</label>
                    <input type="text" class="form-control" id="map_location" name="map_location"
                           value="{{ $settings['map_location'] }}" required>
                    <small class="text-muted">مثال: G792%2BC48%20%D8%A7%D9%84%D9%86%D8%AE%D9%8A%D9%84%20%D8%AC%D8%AF%D8%A9</small>
                </div>

                <div class="mb-3">
                    <label for="map_link" class="form-label">رابط خرائط جوجل الكامل</label>
                    <input type="url" class="form-control" id="map_link" name="map_link"
                           value="{{ $settings['map_link'] }}" required>
                </div>

                <!-- ✅ وصف قسم من نحن -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>وصف قسم "نبذة عن السوق"</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="about_description" class="form-label">الوصف</label>
                            <textarea class="form-control" id="about_description" name="about_description" rows="4">{{ $settings['about_description'] ?? '' }}</textarea>
                            <small class="text-muted">هذا النص يظهر تحت عنوان "نبذة عن السوق"</small>
                        </div>
                    </div>
                </div>

                <!-- ✅ وصف قسم الأقسام -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>وصف قسم "أقسام السوق"</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="departments_description" class="form-label">الوصف</label>
                            <textarea class="form-control" id="departments_description" name="departments_description" rows="3">{{ $settings['departments_description'] ?? '' }}</textarea>
                            <small class="text-muted">هذا النص يظهر تحت عنوان "أقسام السوق"</small>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">حفظ الإعدادات</button>
            </form>
        </div>
    </div>
</div>
@endsection
