@extends('admin.layouts.admin')

@section('title', 'الرسائل')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">الرسائل الواردة</h2>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>رقم الجوال</th>
                        <th>الرسالة</th>
                        <th>التاريخ</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $index => $contact)
                    <tr class="{{ !$contact->is_read ? 'table-primary' : '' }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->phone }}</td>
                        <td>{{ Str::limit($contact->message, 50) }}</td>
                        <td>{{ $contact->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($contact->is_read)
                                <span class="badge bg-success">مقروء</span>
                            @else
                                <span class="badge bg-warning">جديد</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.contacts.show', $contact) }}"
                               class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> عرض
                            </a>
                            <form action="{{ route('admin.contacts.destroy', $contact) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('هل أنت متأكد؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
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
