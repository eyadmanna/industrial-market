@extends('admin.layouts.admin')

@section('title', 'إدارة السلايدر')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>إدارة السلايدر</h2>
        <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> إضافة شريحة جديدة
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($sliders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الصورة</th>
                                <th>العنوان</th>
                                <th>العنوان الفرعي</th>
                                <th>الترتيب</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sliders as $index => $slider)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($slider->image)
                                        <img src="{{ asset('storage/' . $slider->image) }}"
                                             alt="{{ $slider->title }}"
                                             style="width: 100px; height: 70px; object-fit: cover; border-radius: 8px; border: 1px solid #dee2e6;">
                                    @else
                                        <span class="badge bg-secondary">لا توجد صورة</span>
                                    @endif
                                </td>
                                <td class="fw-bold">{{ $slider->title }}</td>
                                <td>{{ Str::limit($slider->subtitle, 30) }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-info">{{ $slider->order }}</span>
                                        <input type="number"
                                            class="form-control form-control-sm order-input"
                                            style="width: 70px; display: none;"
                                            value="{{ $slider->order }}"
                                            min="1"
                                            data-id="{{ $slider->id }}">
                                        <button class="btn btn-sm btn-link p-0 edit-order"
                                                onclick="toggleOrderEdit(this)"
                                                title="تعديل الترتيب">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input toggle-active"
                                               type="checkbox"
                                               id="slider-{{ $slider->id }}"
                                               data-id="{{ $slider->id }}"
                                               {{ $slider->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="slider-{{ $slider->id }}">
                                            {{ $slider->is_active ? 'نشط' : 'غير نشط' }}
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.sliders.edit', $slider) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.sliders.destroy', $slider) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('هل أنت متأكد من حذف هذه الشريحة؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-images" style="font-size: 4rem; color: #ccc;"></i>
                    <h4 class="mt-3">لا توجد شرائح</h4>
                    <p class="text-muted">قم بإضافة أول شريحة الآن</p>
                    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> إضافة شريحة جديدة
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.table th {
    font-weight: 700;
    color: #1e3a5f;
    border-bottom-width: 2px;
}

.table td {
    vertical-align: middle;
}

.form-check-input:checked {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-group {
    gap: 5px;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.order-input {
    display: inline-block;
    text-align: center;
}

.badge.bg-info {
    background-color: #17a2b8 !important;
    font-size: 0.9rem;
    padding: 0.4rem 0.6rem;
}

/* Hover effects */
.table-hover tbody tr:hover {
    background-color: rgba(30, 58, 95, 0.05);
    transition: background-color 0.3s ease;
}

/* Image styling */
.table img {
    transition: transform 0.3s ease;
}

.table img:hover {
    transform: scale(1.1);
    cursor: pointer;
}

/* Empty state styling */
.py-5 i {
    opacity: 0.5;
}

.py-5 h4 {
    color: #1e3a5f;
    font-weight: 700;
}
</style>
@endpush

@push('scripts')
<script>
    function showNotification(type, message) {
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
        toast.style.zIndex = '9999';
        toast.style.minWidth = '300px';
        toast.style.textAlign = 'center';
        toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
        toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

document.addEventListener('DOMContentLoaded', function() {
    // Toggle active status
    document.querySelectorAll('.toggle-active').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const sliderId = this.dataset.id;
            const isActive = this.checked;
            const originalState = !isActive;
            const label = this.nextElementSibling;

            // Disable during request
            this.disabled = true;
            label.textContent = 'جاري التحديث...';

            fetch(`{{ url('admin/sliders') }}/${sliderId}/toggle`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ is_active: isActive })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // تحديث التصنيف
                    label.textContent = isActive ? 'نشط' : 'غير نشط';

                    // إظهار رسالة نجاح صغيرة
                    const toast = document.createElement('div');
                    toast.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
                    toast.style.zIndex = '9999';
                    toast.innerHTML = `
                        ✅ تم تحديث الحالة بنجاح
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.body.appendChild(toast);

                    setTimeout(() => toast.remove(), 3000);
                } else {
                    this.checked = originalState;
                    label.textContent = originalState ? 'نشط' : 'غير نشط';
                    alert('❌ ' + (data.message || 'حدث خطأ'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = originalState;
                label.textContent = originalState ? 'نشط' : 'غير نشط';
                alert('❌ حدث خطأ في الاتصال');
            })
            .finally(() => {
                this.disabled = false;
            });
        });
    });

    // Toggle order input visibility
    window.toggleOrderEdit = function(button) {
        const row = button.closest('tr');
        const badge = row.querySelector('.badge');
        const input = row.querySelector('.order-input');
        const editBtn = button;

        if (input.style.display === 'none' || !input.style.display) {
            // Show input, hide badge
            badge.style.display = 'none';
            input.style.display = 'inline-block';
            editBtn.innerHTML = '<i class="bi bi-check-lg"></i>';
            input.focus();
        } else {
            // Update order
            const sliderId = input.dataset.id;
            const newOrder = parseInt(input.value);

            // Validate order
            if (isNaN(newOrder) || newOrder < 1) {
                showNotification('error', '❌ الرجاء إدخال رقم صحيح');
                input.value = badge.textContent;
                return;
            }

            // Disable during update
            input.disabled = true;
            editBtn.disabled = true;

            fetch(`{{ url('admin/sliders/reorder') }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    order: [{id: sliderId, order: newOrder}]
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update UI
                    badge.textContent = newOrder;
                    badge.style.display = 'inline-block';
                    input.style.display = 'none';
                    editBtn.innerHTML = '<i class="bi bi-pencil"></i>';

                    // Show success message
                    showNotification('success', '✅ تم تحديث الترتيب بنجاح');
                } else {
                    showNotification('error', '❌ ' + (data.message || 'حدث خطأ'));
                    // Revert input
                    input.value = badge.textContent;
                    badge.style.display = 'inline-block';
                    input.style.display = 'none';
                    editBtn.innerHTML = '<i class="bi bi-pencil"></i>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', '❌ حدث خطأ في الاتصال');
                input.value = badge.textContent;
                badge.style.display = 'inline-block';
                input.style.display = 'none';
                editBtn.innerHTML = '<i class="bi bi-pencil"></i>';
            })
            .finally(() => {
                input.disabled = false;
                editBtn.disabled = false;
            });
        }
    };
});
</script>
@endpush
