<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Models\UserModel;
use App\Models\UserProfileModel; // Model profil kita

class RegisterController extends BaseController
{
    public function index()
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        return view('Shield/register');
    }

    public function registerAction()
    {
        if (! $this->validate([
            'email'             => 'required|valid_email|is_unique[auth_identities.secret]',
            'full_name'         => 'required|min_length[3]',
            'password'          => 'required|min_length[8]',
            'password_confirm'  => 'matches[password]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $profileModel = new UserProfileModel();

        // Generate Username unik dari email
        $emailParts = explode('@', $this->request->getPost('email'));
        $baseUsername = $emailParts[0];
        $username = $baseUsername;
        $count = 1;
        while ($userModel->where('username', $username)->first()) {
            $username = $baseUsername . $count;
            $count++;
        }

        // 1. Buat User Shield
        $user = new \CodeIgniter\Shield\Entities\User([
            'username' => $username,
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ]);
        $userModel->save($user);
        
        // Ambil ID user yang baru dibuat
        $user = $userModel->findById($userModel->getInsertID());

        // Tambah ke Grup Default (client)
        $user->addGroup('client');
        $user->activate();

        // 2. Simpan Nama Lengkap ke Profil
        $profileModel->save([
            'user_id'   => $user->id,
            'full_name' => $this->request->getPost('full_name'),
        ]);

        // Login otomatis
        auth()->login($user);

        return redirect()->to(config('Auth')->registerRedirect())->with('message', 'Registrasi berhasil.');
    }
}
