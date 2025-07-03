<?php

namespace App\Controllers\Frontend;

use CodeIgniter\Controller;

class MaintenanceStatusController extends Controller
{
    public function index()
    {
        return $this->response->setJSON([
            'maintenance' => filter_var(env('app.maintenanceMode'), FILTER_VALIDATE_BOOLEAN)
        ]);
    }
}
