<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\FileUpload;
use Exception;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function home_view()
    {
        return Inertia::render('Admin/Index');
    }

    public function message_view()
    {
        return Inertia::render('Admin/Messages');
    }

    public function notification_view()
    {
        return Inertia::render('Admin/Notifications');
    }

    public function profile_view()
    {
        return Inertia::render('Admin/Profile');
    }

    public function add_org_view()
    {
        return Inertia::render('Admin/AddOrganization');
    }
}
