<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function landingpage()
    {
        return view('landingpage.landingpage' ,[
            'name' => 'landingpage',
            'title' => 'landingpage',
        ]);
    }
}
