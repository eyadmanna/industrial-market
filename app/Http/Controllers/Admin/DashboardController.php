<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Section;
use App\Models\Gallery;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'sections_count' => Section::count(),
            'gallery_count' => Gallery::count(),
            'contacts_count' => Contact::count(),
            'unread_contacts' => Contact::where('is_read', false)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
