<?php

namespace App\Http\Controllers\DashboardWeb;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{


    public function index()
    {
        return view('admin.dashboard');
    }

}
