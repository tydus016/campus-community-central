<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class OrganizationsController extends Controller
{
    public function org_profile_view()
    {
        return Inertia::render('Organization/Profile');
    }

    public function post_details_view()
    {
        return Inertia::render('Organization/PostDetails');
    }
}
