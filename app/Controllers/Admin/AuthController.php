<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use App\Libraries\RateLimiter;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        $rateLimiter = new RateLimiter();
        $remainingTime = $rateLimiter->getRemainingTime(); // Get remaining time

        return view('admin/login', ['remainingTime' => $remainingTime]);
    }

    public function attemptLogin()
    {

        $rateLimiter = new RateLimiter();

        // Check if rate limit is exceeded
        if (!$rateLimiter->check()) {
            return redirect()->to('/login')->with('error', 'Too many login attempts. Please try again later.');
        }

        // Validate user input (including captcha)
        $validation = \Config\Services::validation();
        $rules = [
            'username' => 'required',
            'password' => 'required',
            'captcha'  => 'required' // Ensure captcha is validated properly
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Validation failed.');
        }

        $session = session();

        $captchaInput = $this->request->getPost('captcha');

        $captchaStored = $session->get('captcha_code');


        if (strtoupper($captchaInput) !== strtoupper($captchaStored)) {
            return redirect()->to('backend/login')->with('error', 'CAPTCHA salah!');
        }

        $model = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $user = $model->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            $session->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'isLoggedIn' => true
            ]);
            return redirect()->to('/admin/beranda');
        } else {
            return redirect()->to('backend/login')->with('error', 'Username / Password salah!');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/backend/login');
    }

    public function refreshCsrf()
    {
        return $this->response->setJSON([
            'csrfName' => csrf_token(),
            'csrfHash' => csrf_hash()
        ]);
    }
}
