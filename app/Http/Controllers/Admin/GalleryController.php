<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy('order')->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title_ar' => 'nullable|string|max:255',
        ]);

        $path = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'title_ar' => $request->title_ar,
            'image_path' => $path,
            'order' => Gallery::max('order') + 1,
        ]);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'تم إضافة الصورة بنجاح');
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title_ar' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $gallery->update($request->only(['title_ar', 'is_active']));

        return redirect()->route('admin.gallery.index')
            ->with('success', 'تم تحديث الصورة بنجاح');
    }

    public function destroy(Gallery $gallery)
    {
        // حذف الملف
        if (\Storage::disk('public')->exists($gallery->image_path)) {
            \Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'تم حذف الصورة بنجاح');
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            Gallery::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    public function toggle(Request $request, Gallery $gallery)
    {
        try {
            $request->validate([
                'is_active' => 'required|boolean'
            ]);

            $gallery->update([
                'is_active' => $request->is_active
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الحالة بنجاح',
                'is_active' => $gallery->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }
}
