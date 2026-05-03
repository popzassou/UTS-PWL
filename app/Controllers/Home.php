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
            return redirect()->to('/admin');
        }

        $username = session()->get('username');

        $pinjamPath = WRITEPATH . 'peminjaman.json';
        $semuaPinjaman = file_exists($pinjamPath) ? json_decode(file_get_contents($pinjamPath), true) : [];

        $pinjamanSaya = [];
        $totalDipinjam = 0;
        
        // --- VARIABEL UNTUK DENDA ---
        $totalTerlambat = 0; // Berapa kali dia telat
        $totalDenda = 0;     // Total uang dendanya
        $tarifDenda = 5000;  // Misal: denda Rp 5.000 per hari
        $hariIni = strtotime(date('Y-m-d')); // Waktu hari ini dalam detik
        // ----------------------------

        foreach ($semuaPinjaman as $key => $p) {
            if ($p['username'] === $username) {
                // Hitung denda jika statusnya masih dipinjam
                $tglKembali = strtotime($p['tgl_kembali']);
                $dendaBukuIni = 0;

                if ($p['status'] === 'Dipinjam' && $hariIni > $tglKembali) {
                    // Cari selisih detik, lalu ubah ke hari
                    $selisihDetik = $hariIni - $tglKembali;
                    $selisihHari = floor($selisihDetik / (60 * 60 * 24));
                    
                    $dendaBukuIni = $selisihHari * $tarifDenda;
                    $totalDenda += $dendaBukuIni;
                    $totalTerlambat++;
                }

                // Masukkan info denda ke dalam array riwayat agar bisa ditampilkan di tabel
                $p['denda_berjalan'] = $dendaBukuIni;
                $pinjamanSaya[] = $p;
                
                $totalDipinjam++; 
            }
        }

        $bukuTerakhir = null;
        if (!empty($pinjamanSaya)) {
            $bukuTerakhir = end($pinjamanSaya);
        }

        $userData = [
            'username'       => $username,
            'role'           => session()->get('role'),
            'riwayat'        => array_reverse($pinjamanSaya),
            'totalDipinjam'  => $totalDipinjam,
            'bukuTerakhir'   => $bukuTerakhir,
            'totalTerlambat' => $totalTerlambat, // Kirim ke View
            'totalDenda'     => $totalDenda      // Kirim ke View
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
    public function katalog()
    {
        //hanya user yang bisa mengakses halaman ini
        if (session()->get('role') !== 'user') {
            return redirect()->to('/admin');
        }

        $filePath = WRITEPATH . 'buku.json';
        $bukuList = file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : [];

        return view('v_katalog_user', ['buku' => $bukuList]);
    }
    public function pinjamBuku($id_buku)
    {
        // Hanya user yang boleh meminjam
        if (session()->get('role') !== 'user') return redirect()->to('admin');

        $username = session()->get('username');
        $bukuPath = WRITEPATH . 'buku.json';
        $bukuList = file_exists($bukuPath) ? json_decode(file_get_contents($bukuPath), true) : [];
        $bukuFound = false;
        $judulBuku = '';
        
        foreach ($bukuList as $key => $b) {
            if ($b['id_buku'] == $id_buku) {
                if ($b['stok'] > 0) {
                    $bukuList[$key]['stok'] -= 1;
                    $bukuFound = true;
                    $judulBuku = $b['judul'];
                }
                break;
            }
        }

        if (!$bukuFound) {
            session()->setFlashdata('failed', 'Maaf, buku tidak ditemukan atau stok sudah habis.');
            return redirect()->back();
        }

        file_put_contents($bukuPath, json_encode($bukuList, JSON_PRETTY_PRINT));

        $pinjamPath = WRITEPATH . 'peminjaman.json';
        $pinjamList = file_exists($pinjamPath) ? json_decode(file_get_contents($pinjamPath), true) : [];

        $newPinjam = [
            'id_pinjam'   => 'TRX' . time(), // Bikin ID transaksi otomatis dari waktu
            'username'    => $username,
            'id_buku'     => $id_buku,
            'judul'       => $judulBuku,
            'tgl_pinjam'  => date('Y-m-d'),
            'tgl_kembali' => date('Y-m-d', strtotime('+14 days')), // Tenggat waktu 14 hari
            'status'      => 'Dipinjam'
        ];

        $pinjamList[] = $newPinjam;
        file_put_contents($pinjamPath, json_encode($pinjamList, JSON_PRETTY_PRINT));

        session()->setFlashdata('success', 'Berhasil meminjam buku: <strong>' . $judulBuku . '</strong>. Jangan lupa kembalikan tepat waktu!');
        return redirect()->to('/katalog');
    }
}
