<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * عرض قائمة السلايدر
     */
    public function index()
    {
        $sliders = Slider::orderBy('order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * عرض نموذج إضافة سلايدر جديد
     */
    public function create()
    {
        $nextOrder = Slider::max('order') + 1;

        return view('admin.sliders.create', compact('nextOrder'));
    }

    /**
     * تخزين سلايدر جديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['title', 'subtitle', 'is_active']);

        // حساب الترتيب التلقائي - آخر ترتيب + 1
        $maxOrder = Slider::max('order') ?? 0;
        $data['order'] = $maxOrder + 1;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('sliders', 'public');
            $data['image'] = $path;
        }

        // التأكد من أن is_active موجود
        $data['is_active'] = $request->has('is_active') ? true : false;

        Slider::create($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'تم إضافة السلايدر بنجاح');
    }

    /**
     * عرض نموذج تعديل سلايدر
     */
    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

   /**
     * تحديث بيانات سلايدر
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer|min:1',
        ]);

        $data = $request->only(['title', 'subtitle', 'order']);

        // التأكد من أن is_active موجود في الطلب
        $data['is_active'] = $request->has('is_active') ? true : false;

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $path = $request->file('image')->store('sliders', 'public');
            $data['image'] = $path;
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'تم تحديث السلايدر بنجاح');
    }

    /**
     * حذف سلايدر
     */
    public function destroy(Slider $slider)
    {
        // حذف الصورة
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'تم حذف السلايدر بنجاح');
    }

    /**
     * تغيير حالة السلايدر (تفعيل/تعطيل)
     */
    public function toggle(Request $request, Slider $slider)
    {
        try {
            $request->validate([
                'is_active' => 'required|boolean'
            ]);

            $slider->update([
                'is_active' => $request->is_active
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الحالة بنجاح',
                'is_active' => $slider->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * إعادة ترتيب السلايدرات
     */
    public function reorder(Request $request)
    {
        try {
            // التحقق من البيانات
            if (!$request->has('order')) {
                return response()->json([
                    'success' => false,
                    'message' => 'بيانات الترتيب غير موجودة'
                ], 400);
            }

            $orderData = $request->order;

            // إذا كان array من الكائنات مع id و order
            if (is_array($orderData) && isset($orderData[0]['id'])) {
                foreach ($orderData as $item) {
                    if (isset($item['id']) && isset($item['order'])) {
                        Slider::where('id', $item['id'])->update(['order' => $item['order']]);
                    }
                }
            }
            // إذا كان array من الـ ids فقط (نعطي ترتيب حسب index)
            else if (is_array($orderData) && is_numeric($orderData[0])) {
                foreach ($orderData as $index => $id) {
                    Slider::where('id', $id)->update(['order' => $index + 1]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'تم إعادة الترتيب بنجاح'
            ]);
        } catch (\Exception $e) {
            \Log::error('Reorder error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }
}
