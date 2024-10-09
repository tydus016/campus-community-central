<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return Inertia::render('Message/Index');
    }
}
