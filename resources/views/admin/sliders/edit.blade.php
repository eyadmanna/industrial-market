@extends('admin.layouts.admin')

@section('title', 'تعديل الشريحة')

@push('styles')
<style>
.form-check-input:checked {
    background-color: #28a745;
    border-color: #28a745;
}

.form-check-input {
    width: 3rem;
    height: 1.5rem;
    margin-left: 0.5rem;
    cursor: pointer;
}

.form-check-label {
    font-size: 1rem;
    user-select: none;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>تعديل الشريحة: {{ $slider->title }}</h2>
        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-right"></i> عودة
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">العنوان الرئيسي</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                           id="title" name="title" value="{{ old('title', $slider->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="subtitle" class="form-label">العنوان الفرعي</label>
                    <input type="text" class="form-control @error('subtitle') is-invalid @enderror"
                           id="subtitle" name="subtitle" value="{{ old('subtitle', $slider->subtitle) }}" required>
                    @error('subtitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">الصورة الحالية</label>
                    <div class="mb-2">
                        @if($slider->image)
                            <img src="{{ asset('storage/' . $slider->image) }}"
                                 alt="{{ $slider->title }}"
                                 style="width: 300px; height: 150px; object-fit: cover; border-radius: 5px;">
                        @else
                            <p class="text-muted">لا توجد صورة</p>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">تغيير الصورة</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                           id="image" name="image" accept="image/*">
                    <small class="text-muted">اتركه فارغاً إذا لم ترد التغيير</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="order" class="form-label">الترتيب</label>
                    <input type="number" class="form-control @error('order') is-invalid @enderror"
                           id="order" name="order" value="{{ old('order', $slider->order) }}">
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="form-check form-switch m-0">
                            <input type="checkbox" class="form-check-input" id="is_active"
                                name="is_active" value="1" {{ $slider->is_active ? 'checked' : '' }}
                                style="cursor: pointer;">
                        </div>
                        <label class="form-check-label fw-bold" for="is_active" style="cursor: pointer; color: #1e3a5f;">
                            <i class="bi bi-{{ $slider->is_active ? 'check-circle-fill text-success' : 'circle text-secondary' }} me-1"></i>
                            {{ $slider->is_active ? 'الشريحة نشطة' : 'الشريحة غير نشطة' }}
                        </label>
                    </div>
                    <small class="text-muted d-block mt-1 me-4">
                        <i class="bi bi-info-circle me-1"></i>
                        الشرائح غير النشطة لا تظهر في الموقع العام
                    </small>
                </div>

                <button type="submit" class="btn btn-primary">تحديث</button>
            </form>
        </div>
    </div>
</div>
@endsection
