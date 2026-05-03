# Sistem Manajemen Perpustakaan 

Sebuah sistem informasi manajemen perpustakaan berbasis web ringan yang dibangun menggunakan CodeIgniter 4. Aplikasi ini dirancang untuk mendigitalkan proses peminjaman buku, manajemen inventaris stok, dan kalkulasi denda keterlambatan secara otomatis.

## Fitur Utama

**👨‍💼 Panel Admin:**
- **Manajemen Katalog Buku:** Tambah, edit, hapus, dan pantau ketersediaan stok buku.
- **Manajemen Pengguna:** Kontrol akses untuk role Admin dan User.
- **Sistem Transaksi Cerdas:** Melacak buku yang sedang dipinjam dan riwayat peminjaman.
- **Kalkulasi Denda Otomatis:** Sistem secara otomatis menghitung denda keterlambatan (Rp 5.000/hari) secara *real-time* berdasarkan tanggal jatuh tempo.
- **Pengembalian Terintegrasi:** Satu klik untuk mengembalikan buku, menyelesaikan tagihan, dan mengembalikan jumlah stok secara otomatis.

**👤 Portal User (Pengunjung):**
- **E-Katalog:** Penjelajahan koleksi buku perpustakaan yang responsif.
- **Peminjaman Mandiri:** Proses peminjaman buku instan (jika stok tersedia).
- **Dasbor Personal:** Ringkasan status peminjaman aktif, riwayat transaksi, batas waktu pengembalian, dan tagihan denda berjalan.

## 🛠️ Teknologi yang Digunakan

- **Backend:** PHP 8, CodeIgniter 4 Framework
- **Frontend:** HTML5, CSS3, Bootstrap 5 (NiceAdmin Template)
- **Database:** File-based JSON Database (`buku.json`, `peminjaman.json`, `users.json`) - *Ringan dan portabel tanpa perlu setup SQL!*
- **Plugins:** Simple-DataTables (untuk *searching*, *sorting*, dan *pagination* tabel)

## 🚀 Cara Instalasi & Menjalankan Aplikasi

1. Clone repository ini ke komputer lokal kamu:
   ```bash
   git clone https://github.com/popzassou/sistem-informasi-perpustakaan.git
  
2. Masuk ke direktori proyek:
    ```bash
    cd sistem-informasi-perpustakaan

3. Jalankan development server bawaan CodeIgniter:
    ```bash
    php spark serve

4. Buka browser dan akses aplikasi pada: http://localhost:8080

🔐 Kredensial Login (Default)
Gunakan akun berikut untuk mencoba fitur di dalam aplikasi:

Akun Admin:

- Username: admin
- Password: 123

Akun User (Guest):

- Username: (buat user baru via Panel Admin)
- Password: (Sesuaikan)


Proyek ini dikembangkan sebagai bagian dari pembelajaran mata kuliah
