<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::orderBy('order')->get();
        return view('admin.sections.index', compact('sections'));
    }

    public function create()
    {
        return view('admin.sections.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name_ar' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'order' => 'integer|nullable',
    ]);

    $data = $request->only(['name_ar', 'order', 'is_active']);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('sections', 'public');
        $data['image'] = $path;
    }

    Section::create($data);

    return redirect()->route('admin.sections.index')
        ->with('success', 'تم إضافة القسم بنجاح');
}

    public function edit(Section $section)
    {
        return view('admin.sections.edit', compact('section'));
    }

    public function update(Request $request, Section $section)
{
    $request->validate([
        'name_ar' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'order' => 'integer|nullable',
    ]);

    $data = $request->only(['name_ar', 'order', 'is_active']);

    if ($request->hasFile('image')) {
        // حذف الصورة القديمة إذا وجدت
        if ($section->image) {
            \Storage::disk('public')->delete($section->image);
        }
        $path = $request->file('image')->store('sections', 'public');
        $data['image'] = $path;
    }

    $section->update($data);

    return redirect()->route('admin.sections.index')
        ->with('success', 'تم تحديث القسم بنجاح');
}

    public function destroy(Section $section)
    {
        $section->delete();

        return redirect()->route('admin.sections.index')
            ->with('success', 'تم حذف القسم بنجاح');
    }
}
