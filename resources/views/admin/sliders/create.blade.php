@extends('admin.layouts.admin')

@section('title', 'إضافة شريحة جديدة')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>إضافة شريحة جديدة</h2>
        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-right"></i> عودة
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">العنوان الرئيسي</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                           id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="subtitle" class="form-label">العنوان الفرعي</label>
                    <input type="text" class="form-control @error('subtitle') is-invalid @enderror"
                           id="subtitle" name="subtitle" value="{{ old('subtitle') }}" required>
                    @error('subtitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">صورة الخلفية</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                           id="image" name="image" accept="image/*" required>
                    <small class="text-muted">يفضل صورة كبيرة 1920x1080 بكسل</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="order" class="form-label">الترتيب</label>
                    <input type="number" class="form-control @error('order') is-invalid @enderror"
                           id="order" name="order" value="{{ old('order', $nextOrder) }}"
                           min="1" readonly style="background-color: #f8f9fa;">
                    <small class="text-muted">يتم تحديد الترتيب تلقائياً</small>
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="form-check form-switch m-0">
                            <input type="checkbox" class="form-check-input" id="is_active"
                                   name="is_active" value="1" checked style="cursor: pointer;">
                        </div>
                        <label class="form-check-label fw-bold" for="is_active" style="cursor: pointer; color: #1e3a5f;">
                            <i class="bi bi-check-circle-fill text-success me-1"></i>
                            تفعيل الشريحة فور الإضافة
                        </label>
                    </div>
                    <small class="text-muted d-block mt-1 me-4">يمكنك تعطيلها لاحقاً من قائمة الشرائح</small>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> حفظ
                    </button>
                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-x-circle me-1"></i> إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

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

/* تحسين مظهر الحقول */
.form-control:focus {
    border-color: #f5a623;
    box-shadow: 0 0 0 0.2rem rgba(245, 166, 35, 0.25);
}

/* تنسيق زر الحفظ */
.btn-primary {
    background: linear-gradient(135deg, #f5a623, #e09412);
    border: none;
    padding: 0.6rem 2rem;
    font-weight: 600;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #e09412, #d4850a);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(245, 166, 35, 0.3);
}

/* تنسيق زر الإلغاء */
.btn-outline-secondary {
    border: 2px solid #dee2e6;
    color: #1e3a5f;
    font-weight: 600;
}

.btn-outline-secondary:hover {
    background-color: #f8f9fa;
    border-color: #1e3a5f;
    color: #1e3a5f;
    transform: translateY(-2px);
}
</style>
@endpush
