<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\SettingController;

// ✅ الصفحة الرئيسية - متاحة للجميع
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contact', [HomeController::class, 'contact'])->name('contact.send');

// ✅ Dashboard بعد تسجيل الدخول
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

// ✅ لوحة التحكم - تحتاج تسجيل دخول + صلاحيات admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // الأقسام
    Route::resource('sections', SectionController::class);

    // معرض الصور
    Route::resource('gallery', GalleryController::class)->except(['show', 'edit']);
    Route::post('gallery/reorder', [GalleryController::class, 'reorder'])->name('gallery.reorder');

    // الرسائل
    Route::resource('contacts', ContactController::class)->only(['index', 'show', 'destroy']);

    // الإعدادات
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    Route::post('gallery/{gallery}/toggle', [GalleryController::class, 'toggle'])->name('gallery.toggle');
});

// ✅ مسارات المصادقة (Login, Register, etc)
Auth::routes();

// ✅ بعد تسجيل الدخول - وجهة مخصصة
Route::get('/home', function () {
    return redirect()->route('home');
})->name('home');
