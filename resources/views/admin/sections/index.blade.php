@extends('admin.layouts.admin')

@section('title', 'الأقسام')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>إدارة الأقسام</h2>
        <a href="{{ route('admin.sections.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> إضافة قسم جديد
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الصورة</th>
                        <th>اسم القسم</th>
                        <th>الترتيب</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sections as $index => $section)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($section->image)
                                <img src="{{ asset('storage/' . $section->image) }}"
                                     alt="{{ $section->name_ar }}"
                                     style="width: 50px; height: 50px; object-fit: contain;">
                            @else
                                <span class="text-muted">لا توجد</span>
                            @endif
                        </td>
                        <td>{{ $section->name_ar }}</td>
                        <td>{{ $section->order }}</td>
                        <td>
                            @if($section->is_active)
                                <span class="badge bg-success">فعال</span>
                            @else
                                <span class="badge bg-danger">غير فعال</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.sections.edit', $section) }}"
                               class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i> تعديل
                            </a>
                            <form action="{{ route('admin.sections.destroy', $section) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
