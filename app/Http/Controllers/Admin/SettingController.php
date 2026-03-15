<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'phone' => Setting::get('phone'),
            'email' => Setting::get('email'),
            'address' => Setting::get('address'),
            'working_hours' => Setting::get('working_hours'),
            'map_location' => Setting::get('map_location'),
            'map_link' => Setting::get('map_link'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'working_hours' => 'required|string',
            'map_location' => 'required|string',
            'map_link' => 'required|url',
        ]);

        foreach ($request->except('_token') as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings')
            ->with('success', 'تم تحديث الإعدادات بنجاح');
    }
}
