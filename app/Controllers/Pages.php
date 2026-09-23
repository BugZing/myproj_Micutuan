<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function landing()
    {
        return view('landing');
    }

    public function about()
    {
        return view('about');
    }
}