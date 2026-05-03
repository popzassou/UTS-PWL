<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('v_login');
    }
    public function userDashboard()
    {
        if (session()->get('role') !== 'user') {
            return redirect()->to('/user');
        }
        

        $userData = [
            'username' => session()->get('username'),
            'role' => session()->get('role')          
        ];

        return view('v_dashboard_user', $userData);
    }

    public function adminDashboard()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/admin');
        }

        $users = json_decode(file_get_contents(WRITEPATH . 'users.json'), true);

        $userCount = count($users);

        $adminCount = 0;
        $userRoleCount = 0;

        foreach ($users as $user) {
            if ($user['role'] === 'admin') {
                $adminCount++;
            } elseif ($user['role'] === 'user') {
                $userRoleCount++;
            }
        }

        $adminData = [
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'userCount' => $userCount,       
            'adminCount' => $adminCount,     
            'userRoleCount' => $userRoleCount 
        ];

        return view('v_dashboard_admin', $adminData);
    }



    public function users()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('dashboard');
        }
        $users = json_decode(file_get_contents(WRITEPATH . 'users.json'), true);

        return view('v_users', ['users' => $users]);
    }

        public function create()
    {
        return view('v_create_user');  // View untuk form tambah user
    }

    public function store()
    {
        $newUser = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role')
        ];

        $filePath = WRITEPATH . 'users.json';
        $users = json_decode(file_get_contents($filePath), true);
        $users[] = $newUser;

        file_put_contents($filePath, json_encode($users, JSON_PRETTY_PRINT));

        return redirect()->to('/users');
    }

    // Edit form user
    public function edit($username)
    {
        $users = json_decode(file_get_contents(WRITEPATH . 'users.json'), true);

        // Cari user yang ingin diubah
        $user = null;
        foreach ($users as $u) {
            if ($u['username'] == $username) {
                $user = $u;
                break;
            }
        }

        if ($user === null) {
            return redirect()->to('/users'); // User tidak ditemukan
        }

        return view('v_edit_user', ['user' => $user]);
    }

    // Update data user
    public function update($username)
    {
        $users = json_decode(file_get_contents(WRITEPATH . 'users.json'), true);

        foreach ($users as $key => $user) {
            if ($user['username'] == $username) {
                $users[$key]['username'] = $this->request->getPost('username');
                $newPassword = $this->request->getPost('password');
                if (!empty($newPassword)) {
                    $users[$key]['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
                }
                $users[$key]['role'] = $this->request->getPost('role');
                break;
            }
        }

        file_put_contents(WRITEPATH . 'users.json', json_encode($users, JSON_PRETTY_PRINT));

        return redirect()->to('/users');
    }

    // Hapus user
    public function delete($username)
    {
        $users = json_decode(file_get_contents(WRITEPATH . 'users.json'), true);

        foreach ($users as $key => $user) {
            if ($user['username'] == $username) {
                unset($users[$key]);
                break;
            }
        }

        file_put_contents(WRITEPATH . 'users.json', json_encode(array_values($users), JSON_PRETTY_PRINT));

        return redirect()->to('/users');
    }

    public function buku()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('dashboard');
        }

        $filePath = WRITEPATH . 'buku.json';
        if (!file_exists($filePath)) {
            $buku = [];
        } else {
            $buku = json_decode(file_get_contents($filePath), true);
        }

        return view('v_buku', ['buku' => $buku]);
    }


    public function createBuku()
    {
        if (session()->get('role') !== 'admin') return redirect()->to('dashboard');
        return view('v_create_buku');
    }

    public function storeBuku()
    {
        if (session()->get('role') !== 'admin') return redirect()->to('dashboard');

        $id_buku_input = $this->request->getPost('id_buku');
        $filePath = WRITEPATH . 'buku.json';
        $bukuList = file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : [];

        foreach ($bukuList as $b) {
            if ($b['id_buku'] === $id_buku_input) {
                session()->setFlashdata('failed', 'ID Buku "'. $id_buku_input .'" sudah terdaftar! Silakan gunakan ID lain.');
                return redirect()->back(); 
            }
        }

        $newBuku = [
            'id_buku'   => $id_buku_input,
            'judul'     => $this->request->getPost('judul'),
            'pengarang' => $this->request->getPost('pengarang'),
            'penerbit'  => $this->request->getPost('penerbit'),
            'tahun'     => $this->request->getPost('tahun'),
            'stok'      => (int)$this->request->getPost('stok')
        ];
        
        $bukuList[] = $newBuku;
        file_put_contents($filePath, json_encode($bukuList, JSON_PRETTY_PRINT));

        return redirect()->to('/buku');
    }

    public function editBuku($id_buku)
    {
        if (session()->get('role') !== 'admin') return redirect()->to('dashboard');

        $filePath = WRITEPATH . 'buku.json';
        $bukuList = file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : [];

        $buku = null;
        foreach ($bukuList as $b) {
            if ($b['id_buku'] == $id_buku) {
                $buku = $b;
                break;
            }
        }

        if ($buku === null) return redirect()->to('/buku');
        
        return view('v_edit_buku', ['buku' => $buku]);
    }

    public function updateBuku($id_buku)
    {
        if (session()->get('role') !== 'admin') return redirect()->to('dashboard');

        $filePath = WRITEPATH . 'buku.json';
        $bukuList = file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : [];

        foreach ($bukuList as $key => $b) {
            if ($b['id_buku'] == $id_buku) {
                $bukuList[$key]['judul']     = $this->request->getPost('judul');
                $bukuList[$key]['pengarang'] = $this->request->getPost('pengarang');
                $bukuList[$key]['penerbit']  = $this->request->getPost('penerbit');
                $bukuList[$key]['tahun']     = $this->request->getPost('tahun');
                $bukuList[$key]['stok']      = (int)$this->request->getPost('stok');
                break;
            }
        }

        file_put_contents($filePath, json_encode($bukuList, JSON_PRETTY_PRINT));
        return redirect()->to('/buku');
    }

    public function deleteBuku($id_buku)
    {
        if (session()->get('role') !== 'admin') return redirect()->to('dashboard');

        $filePath = WRITEPATH . 'buku.json';
        $bukuList = file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : [];

        foreach ($bukuList as $key => $b) {
            if ($b['id_buku'] == $id_buku) {
                unset($bukuList[$key]);
                break;
            }
        }

        file_put_contents($filePath, json_encode(array_values($bukuList), JSON_PRETTY_PRINT));
        return redirect()->to('/buku');
    }
}
