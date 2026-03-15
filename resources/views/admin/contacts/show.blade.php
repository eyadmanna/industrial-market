@extends('admin.layouts.admin')

@section('title', 'عرض الرسالة')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>تفاصيل الرسالة</h2>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-right"></i> عودة
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <span>من: {{ $contact->name }}</span>
                <span class="text-muted">{{ $contact->created_at->format('Y-m-d H:i') }}</span>
            </div>
        </div>
        <div class="card-body">
            <p><strong>رقم الجوال:</strong> {{ $contact->phone }}</p>
            <hr>
            <p><strong>الرسالة:</strong></p>
            <p class="p-3 bg-light">{{ $contact->message }}</p>
        </div>
    </div>
</div>
@endsection
