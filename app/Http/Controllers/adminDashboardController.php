<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminDashboardController extends Controller
{
    public function dashboard()
    {
        return view('admin.page.dashboard' ,[
            'name' => 'Dashboard',
            'title' => 'Dashboard',
        ]);
    }
}
