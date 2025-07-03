<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;

class Layanan extends BaseController
{
    public function index()
    {
        return view('frontend/layanan');
    }
}
