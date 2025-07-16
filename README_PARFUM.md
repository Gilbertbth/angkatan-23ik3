# Sistem Informasi Penjualan Parfum

Aplikasi web untuk mengelola inventory dan penjualan parfum menggunakan PHP dan MySQL.

## Fitur Utama

✅ **Autentikasi Pengguna**
- Login dan logout
- Session management
- Validasi keamanan

✅ **Manajemen Parfum (CRUD)**
- Tambah parfum baru
- Edit data parfum
- Hapus parfum
- Pencarian dan filter

✅ **Dashboard Admin**
- Tampilan daftar parfum
- Statistik inventory
- Interface yang user-friendly

## Persyaratan Sistem

- PHP 7.4 atau lebih baru
- MySQL 5.7 atau lebih baru
- Apache/Nginx web server
- XAMPP/WAMP/LAMP (untuk development)

## Instalasi

### 1. Persiapan Database

1. Buka phpMyAdmin di `http://localhost/phpmyadmin`
2. Buat database baru bernama `sistem_parfum`
3. Import file `database.sql` yang disediakan

### 2. Konfigurasi Database

Edit file `config.php` jika perlu mengubah pengaturan database:

```php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'sistem_parfum';
```

### 3. Menjalankan Aplikasi

1. Salin semua file ke dalam folder web server (htdocs untuk XAMPP)
2. Buka browser dan akses `http://localhost/folder-aplikasi`
3. Anda akan diarahkan ke halaman login

## Login Default

```
Username: admin
Password: admin123
```

## Struktur Database

### Tabel `users`
- `id` (Primary Key)
- `username` (Unique)
- `password` (Hashed)
- `email`
- `created_at`

### Tabel `parfum`
- `id` (Primary Key)
- `nama_parfum`
- `merk`
- `jenis_kelamin` (Pria/Wanita/Unisex)
- `ukuran`
- `harga`
- `stok`
- `deskripsi`
- `gambar`
- `created_at`
- `updated_at`

## Cara Penggunaan

### Login
1. Masuk ke halaman utama
2. Gunakan username dan password yang tersedia
3. Klik "Login"

### Menambah Parfum
1. Dari dashboard, klik "Tambah Parfum Baru"
2. Isi semua field yang diperlukan
3. Klik "Tambah Parfum"

### Mengedit Parfum
1. Dari dashboard, klik tombol "Edit" pada parfum yang diinginkan
2. Ubah data yang diperlukan
3. Klik "Update Parfum"

### Menghapus Parfum
1. Dari dashboard, klik tombol "Hapus" pada parfum yang diinginkan
2. Konfirmasi penghapusan
3. Klik "Ya, Hapus Parfum"

### Mencari Parfum
1. Gunakan kotak pencarian untuk mencari berdasarkan nama atau merk
2. Gunakan filter gender untuk memfilter berdasarkan jenis kelamin
3. Klik "Filter" atau "Reset" untuk menghapus filter

## Keamanan

- Password di-hash menggunakan PHP password_hash()
- Prepared statements untuk mencegah SQL injection
- Session-based authentication
- Input validation dan sanitization
- CSRF protection pada form

## Fitur Tambahan

- **Responsive Design**: Tampilan yang menyesuaikan dengan berbagai ukuran layar
- **Search & Filter**: Pencarian dan filter berdasarkan berbagai kriteria
- **Modern UI**: Interface yang clean dan user-friendly
- **Error Handling**: Pesan error yang informatif
- **Success Messages**: Konfirmasi untuk setiap aksi yang berhasil

## File Struktur

```
/
├── config.php          # Konfigurasi database
├── index.php           # Entry point utama
├── login.php           # Halaman login
├── logout.php          # Proses logout
├── dashboard.php       # Dashboard utama
├── add_parfum.php      # Tambah parfum
├── edit_parfum.php     # Edit parfum
├── delete_parfum.php   # Hapus parfum
├── style.css           # Styling CSS
├── database.sql        # Database schema
└── README_PARFUM.md    # Dokumentasi
```

## Troubleshooting

### Error Koneksi Database
- Pastikan MySQL server berjalan
- Periksa konfigurasi di `config.php`
- Pastikan database `sistem_parfum` sudah dibuat

### Error Permission
- Pastikan file memiliki permission yang benar
- Untuk Linux/Mac: `chmod 644` untuk file, `chmod 755` untuk folder

### Error Session
- Pastikan session dapat ditulis ke server
- Periksa pengaturan session di php.ini

## Pengembangan Lebih Lanjut

Fitur yang bisa ditambahkan:
- Upload gambar parfum
- Laporan penjualan
- Management user/admin
- Kategori parfum
- Sistem notifikasi stok
- Export data ke Excel/PDF

## Lisensi

Aplikasi ini dibuat untuk keperluan pembelajaran dan pengembangan.

## Kontak

Jika ada pertanyaan atau masalah, silakan hubungi developer.