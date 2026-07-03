<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function cars()
    {
        return view('admin.cars');
    }

    public function bookings()
    {
        return view('admin.bookings');
    }

    public function guides()
    {
        return view('admin.guides');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function users()
    {
        return view('admin.users');
    }
}
