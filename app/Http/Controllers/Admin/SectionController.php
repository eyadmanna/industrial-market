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
            'icon' => 'required|string|max:10',
            'order' => 'integer',
        ]);

        Section::create($request->all());

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
            'icon' => 'required|string|max:10',
            'order' => 'integer',
        ]);

        $section->update($request->all());

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
