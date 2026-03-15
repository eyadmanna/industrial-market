@extends('admin.layouts.admin')

@section('title', 'تعديل قسم')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>تعديل القسم: {{ $section->name_ar }}</h2>
        <a href="{{ route('admin.sections.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-right"></i> عودة
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.sections.update', $section) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name_ar" class="form-label">اسم القسم</label>
                    <input type="text" class="form-control @error('name_ar') is-invalid @enderror"
                           id="name_ar" name="name_ar" value="{{ old('name_ar', $section->name_ar) }}" required>
                    @error('name_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">الصورة الحالية</label>
                    <div class="mb-2">
                        @if($section->image)
                            <img src="{{ asset('storage/' . $section->image) }}"
                                 alt="{{ $section->name_ar }}"
                                 style="width: 100px; height: 100px; object-fit: contain; border: 1px solid #ddd; padding: 5px;">
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
                           id="order" name="order" value="{{ old('order', $section->order) }}">
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active"
                           name="is_active" value="1" {{ $section->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">فعال</label>
                </div>

                <button type="submit" class="btn btn-primary">تحديث</button>
            </form>
        </div>
    </div>
</div>
@endsection
