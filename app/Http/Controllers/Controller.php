<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function monitoring()
    {
        return view('admin.page.monitoring' ,[
            'name' => 'monitoring',
            'title' => 'monitoring',
        ]);
    }
    public function landingpage()
    {
        return view('landingpage.landingpage' ,[
            'name' => 'landingpage',
            'title' => 'landingpage',
        ]);
    }
}
