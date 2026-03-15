@extends('admin.layouts.admin')

@section('title', 'الرئيسية')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">لوحة التحكم</h2>

    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">الأقسام</h6>
                            <h2>{{ $stats['sections_count'] }}</h2>
                        </div>
                        <i class="bi bi-grid-3x3-gap-fill" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">الصور</h6>
                            <h2>{{ $stats['gallery_count'] }}</h2>
                        </div>
                        <i class="bi bi-images" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">إجمالي الرسائل</h6>
                            <h2>{{ $stats['contacts_count'] }}</h2>
                        </div>
                        <i class="bi bi-envelope" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">رسائل غير مقروءة</h6>
                            <h2>{{ $stats['unread_contacts'] }}</h2>
                        </div>
                        <i class="bi bi-envelope-exclamation" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>آخر الرسائل</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>رقم الجوال</th>
                                <th>التاريخ</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Contact::latest()->take(5)->get() as $contact)
                            <tr>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->phone }}</td>
                                <td>{{ $contact->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if($contact->is_read)
                                        <span class="badge bg-success">مقروء</span>
                                    @else
                                        <span class="badge bg-warning">غير مقروء</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
