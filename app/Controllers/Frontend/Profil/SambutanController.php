<?php

namespace App\Controllers\Frontend\Profil;

use App\Controllers\BaseController;
use App\Models\Profil\SambutanModel;

class SambutanController extends BaseController
{
    public function index()
    {
        $model = new SambutanModel();
        $sambutan = $model->first(); // Assuming there's only one row

        return view('frontend/profil/sambutan', [
            'title' => 'Sambutan Kepala Puskesmas',
            'sambutan' => $sambutan
        ]);
    }
}
