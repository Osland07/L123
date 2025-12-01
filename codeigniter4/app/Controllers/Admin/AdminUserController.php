<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Models\UserModel;

class AdminUserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        
        if ($keyword) {
            // Cari berdasarkan username atau email
            $users = $this->userModel->groupStart()
                        ->like('username', $keyword)
                        ->orLike('secret', $keyword) // 'secret' stores email in default Shield setup (identity)
                        ->groupEnd()
                        ->findAll();
        } else {
            $users = $this->userModel->findAll();
        }

        // Kita perlu mengambil identitas email secara eksplisit karena struktur Shield
        // Tapi findAll() di UserModel biasanya sudah join identities jika dikonfigurasi.
        // Untuk simplisitas, kita loop di view atau join manual jika perlu.
        // Default Shield user object punya method getEmail().

        $data = [
            'title'   => 'Manajemen Pengguna',
            'users'   => $users,
            'keyword' => $keyword
        ];

        return view('Admin/users/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Tambah Pengguna Baru',
        ];
        return view('Admin/users/create', $data);
    }

    public function create()
    {
        // Validasi Input
        if (!$this->validate([
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[auth_identities.secret]',
            'password' => 'required|min_length[8]',
            'role'     => 'required|in_list[admin,client]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Buat Entity User Baru
        $user = new \CodeIgniter\Shield\Entities\User([
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ]);

        // Simpan User
        $this->userModel->save($user);

        // Dapatkan ID User yang baru dibuat
        $user = $this->userModel->findById($this->userModel->getInsertID());

        // Tambahkan ke Grup sesuai pilihan
        $user->addGroup($this->request->getPost('role'));

        // Activate User
        $user->activate();

        return redirect()->to('/admin/users')->with('message', 'Pengguna baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = $this->userModel->findById($id);
        
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Pengguna tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Pengguna',
            'user'  => $user,
        ];

        return view('Admin/users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->findById($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Pengguna tidak ditemukan.');
        }

        $email = $this->request->getPost('email');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Update Basic Info
        $user->fill([
            'username' => $username,
        ]);

        // Jika email berubah (perlu penanganan khusus identity di Shield, tapi coba fill dulu)
        if ($email !== $user->email) {
            $user->email = $email;
        }

        // Jika password diisi, update password
        if (!empty($password)) {
            $user->password = $password;
        }

        if ($this->userModel->save($user)) {
            return redirect()->to('/admin/users')->with('message', 'Data pengguna berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }
    }

    public function delete($id)
    {
        if ($this->userModel->delete($id, true)) { // true for purge/hard delete
            return redirect()->to('/admin/users')->with('message', 'Pengguna berhasil dihapus.');
        }
        return redirect()->to('/admin/users')->with('error', 'Gagal menghapus pengguna.');
    }
}
