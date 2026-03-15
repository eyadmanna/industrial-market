<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Gallery;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sections = Section::where('is_active', true)
            ->orderBy('order')
            ->get();

        $galleries = Gallery::where('is_active', true)
            ->orderBy('order')
            ->get();

        $features = [
            ['icon' => '📍', 'text' => 'موقع واحد'],
            ['icon' => '🧩', 'text' => 'تخصصات متعددة'],
            ['icon' => '🧭', 'text' => 'تنظيم واضح'],
            ['icon' => '✅', 'text' => 'سهولة الوصول'],
        ];

        $settings = [
            'phone' => Setting::get('phone', '0501234567'),
            'email' => Setting::get('email', 'info@example.com'),
            'address' => Setting::get('address', 'حي النخيل - جدة - المملكة العربية السعودية'),
            'working_hours' => Setting::get('working_hours', 'السبت–الخميس: 8:00 ص – 8:00 م'),
            'map_location' => Setting::get('map_location', 'G792%2BC48%20%D8%A7%D9%84%D9%86%D8%AE%D9%8A%D9%84%20%D8%AC%D8%AF%D8%A9'),
            'map_link' => Setting::get('map_link', 'https://maps.app.goo.gl/3SkkY5sLWqqXQfZn8'),
        ];

        return view('home', compact('sections', 'galleries', 'features', 'settings'));
    }

    public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        \App\Models\Contact::create([
            'name' => $request->name,
            'phone' => $request->subject ?? 'غير محدد',
            'message' => $request->message,
        ]);

        return response()->json(['success' => true, 'message' => 'تم استلام رسالتك بنجاح']);
    }
}
