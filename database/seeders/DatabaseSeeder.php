<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Section;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // إنشاء مستخدم admin
        User::create([
            'name' => 'مدير الموقع',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // إنشاء الأقسام
        $sections = [
            ['معدات كهربائية', '⚙️', 1],
            ['أدوات ورش', '🔧', 2],
            ['معدات لحام', '⚡', 3],
            ['مستلزمات السلامة', '🛡️', 4],
            ['هيدروليك', '💧', 5],
            ['ضواغط وهواء', '💨', 6],
            ['رافعات ومناولة', '🏗️', 7],
            ['أنابيب ووصلات', '🔩', 8],
            ['قص وثقب', '⚒️', 9],
            ['دهان وتشطيب', '🎨', 10],
            ['قطع غيار', '⚙️', 11],
            ['مستلزمات صناعية', '🏭', 12],
            ['عدد يدوية', '🔨', 13],
            ['مضخات', '💧', 14],
        ];

        foreach ($sections as $index => $section) {
            Section::create([
                'name_ar' => $section[0],
                'icon' => $section[1],
                'order' => $section[2],
                'is_active' => true,
            ]);
        }

        // إنشاء الإعدادات
        $settings = [
            ['phone', '0501234567', 'text'],
            ['email', 'info@example.com', 'text'],
            ['address', 'النخيل - جدة - المملكة العربية السعودية', 'text'],
            ['working_hours', 'السبت–الخميس: 8:00 ص – 8:00 م', 'text'],
            ['map_location', 'G792%2BC48%20%D8%A7%D9%84%D9%86%D8%AE%D9%8A%D9%84%20%D8%AC%D8%AF%D8%A9', 'text'],
            ['map_link', 'https://maps.app.goo.gl/3SkkY5sLWqqXQfZn8', 'text'],
        ];

        foreach ($settings as $setting) {
            Setting::create([
                'key' => $setting[0],
                'value' => $setting[1],
                'type' => $setting[2],
            ]);
        }
    }
}
