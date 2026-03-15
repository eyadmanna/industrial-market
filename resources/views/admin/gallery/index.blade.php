@extends('admin.layouts.admin')

@section('title', 'معرض الصور')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>إدارة معرض الصور</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
            <i class="bi bi-cloud-upload"></i> رفع صورة جديدة
        </button>
    </div>

    <div class="row">
        @foreach($galleries as $gallery)
        <div class="col-md-3 mb-3">
            <div class="card">
                <img src="{{ asset('storage/' . $gallery->image_path) }}"
                     class="card-img-top" style="height: 150px; object-fit: cover;">
                <div class="card-body">
                    <p class="card-text">{{ $gallery->title_ar ?? 'بدون عنوان' }}</p>
                    <div class="d-flex justify-content-between">
                        <div class="form-check form-switch">
                            <input class="form-check-input toggle-active" type="checkbox"
                                   data-id="{{ $gallery->id }}"
                                   {{ $gallery->is_active ? 'checked' : '' }}>
                        </div>
                        <form action="{{ route('admin.gallery.destroy', $gallery) }}"
                              method="POST" onsubmit="return confirm('هل أنت متأكد؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal رفع الصور -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">رفع صورة جديدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title_ar" class="form-label">عنوان الصورة</label>
                        <input type="text" class="form-control" id="title_ar" name="title_ar">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">اختر صورة</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">رفع</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.toggle-active').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        fetch(`/admin/gallery/${this.dataset.id}/toggle`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ is_active: this.checked })
        });
    });
});
</script>
@endpush
