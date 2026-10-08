<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('staff_id')) {
            return redirect()->to(site_url('dashboard'));
        }

        return view('auth/login');
    }

    public function attempt()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        $user = (new UserModel())->where('username', $username)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Incorrect username or password.');
        }

        $session = session();
        $session->regenerate(true);
        $session->set([
            'staff_id'   => $user['id'],
            'staff_name' => $user['full_name'],
        ]);

        return redirect()->to(site_url('dashboard'));
    }

    public function dashboard()
    {
        if (!session()->get('staff_id')) {
            return redirect()->to(site_url('login'));
        }

        return view('dashboard');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('login'));
    }
}