<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Gallery;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sections = Section::where('is_active', true)
            ->orderBy('order')
            ->get();

        foreach($sections as $section) {
            if($section->image) {
                $section->image_url = asset('storage/' . $section->image);
            }
        }

        $galleries = Gallery::where('is_active', true)
            ->orderBy('order')
            ->get();

        foreach($galleries as $gallery) {
            if($gallery->image_path) {
                $gallery->image_url = asset('storage/' . $gallery->image_path);
            }
        }

        $sliderData = Slider::where('is_active', true)
            ->orderBy('order')
            ->get()
            ->map(function($slider) {
                return [
                    'image' => asset('storage/' . $slider->image),
                    'title' => $slider->title,
                    'subtitle' => $slider->subtitle
                ];
            });
        // بيانات السلايدر - تعديل المسار ليشمل media/
        /*$sliderData = [
            [
                'image' => 'assets/media/first-hero.jpeg',
                'title' => 'سوق العدد الصناعية',
                'subtitle' => 'موقع واحد يضم نخبة من موردي العدد الصناعية',
            ],
            [
                'image' => 'assets/media/second-hero.jpeg',
                'title' => 'أفضل سوق العدد الصناعية',
                'subtitle' => 'نوفر لك أحدث العدد وأكثرها كفاءة من أبرز الموردين',
            ],
            [
                'image' => 'assets/media/first-hero.jpeg',
                'title' => 'شركاء النجاح الصناعي',
                'subtitle' => 'نربطك بأفضل موردي العدد الصناعية في المنطقة',
            ],
        ];*/


        $aboutDescription = Setting::get('about_description', 'يقدم سوق العدد الصناعية خدمات متكاملة تشمل 14 قسم إلى أسماء. نهدف لتقديم كل ما يخدم عملاءنا في جهة واحدة، مع أفضل العدد الصناعية. مما يجعل السوق وجهة آمنة تلبي احتياجات القطاع الصناعي المتنوع.');

        // نص قسم الأقسام
        $departmentsDescription = Setting::get('departments_description', 'يضم السوق أقساماً متخصصة .. كل قسم مستقل ومتخصص في مجال عمل محدد');

        // مميزات القسم - تعديل المسار ليشمل media/
        $features = [
            ['label' => 'سهولة الوصول', 'icon' => 'assets/media/about-icon-one.png'],
            ['label' => 'تنظيم واضح', 'icon' => 'assets/media/about-icon-two.png'],
            ['label' => 'تخصصات متعددة', 'icon' => 'assets/media/about-icon-three.png'],
            ['label' => 'موقع واحد', 'icon' => 'assets/media/about-icon-four.png'],
        ];

        // بيانات الاتصال
        $contactData = [
            'phone' => Setting::get('phone', '+966 50 553 5649'),
            'email' => Setting::get('email', 'info@itm-sa.com'),
            'addressLabel' => Setting::get('address', 'حي النخيل - جده - المملكة العربية السعودية'),
            'working_hours' => Setting::get('working_hours', 'الأحد - الخميس : 8:00 ص - 8:00 م'),
        ];

        // بيانات الخريطة - تعديل مسار الصورة
        $mapData = [
            'locationLabel' => Setting::get('address', 'المنطقة - الصناعية - المدينة'),
            'directionsUrl' => Setting::get('map_link', 'https://maps.app.goo.gl/3SkkY5sLWqqXQfZn8'),
            'buildingImage' => 'assets/media/image-map.jpg',
            'mapEmbedUrl' => 'https://maps.google.com/maps?q=' . urlencode(Setting::get('address', '21.5185334,39.2503431')) . '&output=embed',
        ];

        // إعدادات عامة
        $settings = [
            'phone' => $contactData['phone'],
            'email' => $contactData['email'],
            'address' => $contactData['addressLabel'],
            'working_hours' => $contactData['working_hours'],
            'map_location' => Setting::get('map_location', '21.5185334,39.2503431'),
            'map_link' => $mapData['directionsUrl'],
        ];

        return view('home', compact(
            'sections',
            'galleries',
            'sliderData',
            'aboutDescription',
            'departmentsDescription',
            'features',
            'contactData',
            'mapData',
            'settings'
        ));
    }

   public function contact(Request $request)
{
    try {
        // التحقق من صحة البيانات
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في التحقق من البيانات',
                'errors' => $validator->errors()
            ], 422);
        }

        // تخزين البيانات في قاعدة البيانات
        $contact = \App\Models\Contact::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'message' => $request->message,
            'is_read' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال الرسالة بنجاح',
            'data' => [
                'id' => $contact->id,
                'name' => $contact->name,
                'created_at' => $contact->created_at->format('Y-m-d H:i')
            ]
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'خطأ في التحقق من البيانات',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        \Log::error('Contact form error: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'حدث خطأ في الخادم، الرجاء المحاولة لاحقاً'
        ], 500);
    }
}
}
