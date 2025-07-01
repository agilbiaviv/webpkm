<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password', 'created_at'];

    public function attemptLogin()
{
    $session = session();
    $model = new UserModel();
    
    // Sanitize input
    $username = filter_var($this->request->getPost('username'), FILTER_SANITIZE_STRING);
    $password = $this->request->getPost('password');
    
    // Validate inputs
    if (empty($username) || empty($password)) {
        return redirect()->back()->with('error', 'Username and password are required.');
    }

    // Check login attempts
    if ($session->get('login_attempts') >= 3) {
        if (time() - $session->get('last_attempt_time') < 120) {
            return redirect()->back()->with('error', 'Too many attempts. Try again later.');
        } else {
            $session->remove('login_attempts');
            $session->remove('last_attempt_time');
        }
    }

    // Fetch user data
    $user = $model->where('username', $username)->first();

    if ($user && password_verify($password, $user['password'])) {
        $session->set([
            'user_id' => $user['id'],
            'username' => $user['username'],
            'logged_in' => true
        ]);

        // Reset login attempts on success
        $session->remove('login_attempts');
        return redirect()->to('/admin');
    } else {
        // Track login attempts
        $attempts = $session->get('login_attempts') ?? 0;
        $session->set('login_attempts', $attempts + 1);
        $session->set('last_attempt_time', time());

        return redirect()->back()->with('error', 'Invalid credentials.');
    }
}

}

