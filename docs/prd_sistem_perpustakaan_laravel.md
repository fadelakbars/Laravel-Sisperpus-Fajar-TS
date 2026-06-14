# Dokumen Persyaratan Produk (PRD) & Panduan Implementasi
## Sistem Informasi Perpustakaan Kampus Sederhana (Sisperpus)
**Berbasis Laravel 13**

---

## 1. Ringkasan Produk
Sistem Informasi Perpustakaan Kampus Sederhana (**Sisperpus**) adalah aplikasi web internal untuk mendigitalisasi pengelolaan katalog buku, sirkulasi peminjaman, pengembalian, dan pemantauan denda di lingkungan perpustakaan jurusan atau kampus.

Dokumen ini menjadi acuan rancangan sebelum implementasi. Fokus utamanya adalah menghasilkan struktur data, alur bisnis, dan pembagian hak akses yang jelas agar tahap pengembangan dapat dilakukan secara bertahap dan tetap konsisten dengan basis proyek yang sudah diinisialisasi.

### Target Pengguna
1. **Pustakawan (Admin):** Mengelola data buku, memproses peminjaman dan pengembalian, serta memantau denda.
2. **Mahasiswa (Anggota):** Mencari buku, melihat status peminjaman pribadi, dan memantau keterlambatan.

### Tujuan Utama
1. Memusatkan data buku dan transaksi perpustakaan dalam satu sistem.
2. Mengurangi pencatatan manual yang rawan salah.
3. Menyediakan riwayat sirkulasi yang mudah ditelusuri.
4. Mengotomatisasi aturan stok dan denda keterlambatan.

---

## 2. Keputusan Teknis Dasar

### 2.1 Stack Proyek
1. **Framework:** Laravel 13
2. **Bahasa:** PHP 8.3+  
   Catatan: implementasi sebaiknya tetap kompatibel minimal dengan PHP 8.3 sesuai basis proyek yang diinginkan.
3. **Database:** MySQL
4. **Frontend:** Blade, Tailwind CSS, dan JavaScript ringan bawaan Laravel bila diperlukan

### 2.2 Batasan Rancangan
1. **Tidak menggunakan Filament.**
2. Panel admin dan halaman anggota dibangun dengan pola Laravel standar: route, controller, request validation, service atau action bila diperlukan, model, dan Blade views.
3. Penamaan **tabel** dan **kolom domain** menggunakan **bahasa Indonesia**.
4. Tabel bawaan Laravel yang sudah dimigrasikan, seperti `users`, `cache`, `jobs`, dan tabel pendukung bawaan lainnya, **tidak perlu diubah namanya**.

---

## 3. Arsitektur Data & Skema Database
Relasi inti sistem:

```text
[users] 1 ------ 0..* [peminjaman] *..0 ------ 1 [buku]
```

### 3.1 Prinsip Penamaan
1. Tabel domain menggunakan bentuk tunggal yang sudah lazim dipakai pada proyek ini: `buku`, `peminjaman`.
2. Nama kolom domain menggunakan bahasa Indonesia dengan format `snake_case`.
3. Foreign key pada tabel domain juga menggunakan bahasa Indonesia, misalnya `anggota_id` dan `buku_id`.
4. Tabel `users` tetap mengikuti tabel bawaan Laravel, namun kolom tambahan yang khusus untuk kebutuhan domain perpustakaan harus dinamai secara jelas dan konsisten.

### 3.2 Tabel: `users` (Bawaan Laravel + Atribut Tambahan)
Menyimpan data akun dan identitas pengguna.

Kolom bawaan Laravel tetap dipertahankan:
1. `id`
2. `name`
3. `email`
4. `password`
5. `remember_token`
6. `created_at`
7. `updated_at`

Kolom tambahan domain:
1. `nim` (string, unik, nullable)  
   Digunakan untuk mahasiswa.
2. `peran` (enum: `admin`, `anggota`; default: `anggota`)

### 3.3 Tabel: `buku`
Menyimpan katalog buku perpustakaan.

1. `id` (bigIncrements, primary key)
2. `isbn` (string, unik)
3. `judul` (string)
4. `penulis` (string)
5. `penerbit` (string)
6. `tahun_terbit` (integer)
7. `stok` (integer, default: 0)
8. `lokasi_rak` (string)
9. `created_at`
10. `updated_at`

### 3.4 Tabel: `peminjaman`
Menyimpan transaksi peminjaman dan pengembalian buku.

1. `id` (bigIncrements, primary key)
2. `anggota_id` (foreignId, mengarah ke `users.id`, cascade on delete)
3. `buku_id` (foreignId, mengarah ke `buku.id`, cascade on delete)
4. `tanggal_pinjam` (date)
5. `tanggal_jatuh_tempo` (date)
6. `tanggal_kembali` (date, nullable)
7. `jumlah_denda` (decimal 10,2, default: 0.00)
8. `status_peminjaman` (enum: `dipinjam`, `dikembalikan`, `terlambat`; default: `dipinjam`)
9. `created_at`
10. `updated_at`

### 3.5 Aturan Relasi
1. Satu `user` dengan `peran = anggota` dapat memiliki banyak data `peminjaman`.
2. Satu `buku` dapat muncul di banyak data `peminjaman`.
3. Setiap data `peminjaman` wajib terhubung ke satu `anggota` dan satu `buku`.

---

## 4. Fitur Inti Sistem

### 4.1 Modul Admin (Pustakawan)
1. Login admin.
2. Kelola data buku: tambah, lihat, ubah, hapus.
3. Kelola data anggota perpustakaan.
4. Catat transaksi peminjaman buku.
5. Proses pengembalian buku.
6. Lihat daftar peminjaman aktif, sudah kembali, dan terlambat.
7. Lihat dan verifikasi nilai denda keterlambatan.

### 4.2 Modul Anggota (Mahasiswa)
1. Login anggota.
2. Lihat katalog buku.
3. Cari buku berdasarkan judul, penulis, penerbit, atau ISBN.
4. Lihat status ketersediaan buku.
5. Lihat riwayat peminjaman pribadi.
6. Lihat status keterlambatan dan total denda pribadi.

---

## 5. Matriks Hak Akses

| Fitur / Modul | Admin | Anggota |
| :--- | :---: | :---: |
| Lihat katalog buku | Ya | Ya |
| Tambah / ubah / hapus buku | Ya | Tidak |
| Lihat data anggota | Ya | Tidak |
| Kelola data anggota | Ya | Tidak |
| Catat peminjaman | Ya | Tidak |
| Proses pengembalian | Ya | Tidak |
| Lihat seluruh transaksi peminjaman | Ya | Tidak |
| Lihat transaksi milik sendiri | Tidak | Ya |
| Lihat denda seluruh anggota | Ya | Tidak |
| Lihat denda pribadi | Tidak | Ya |

---

## 6. Aturan Bisnis

### 6.1 Aturan Stok Buku
1. Saat transaksi peminjaman baru dibuat, `stok` pada tabel `buku` berkurang 1.
2. Saat buku dikembalikan, `stok` pada tabel `buku` bertambah 1.
3. Sistem harus menolak peminjaman jika `stok` buku bernilai 0.
4. Perubahan transaksi peminjaman dan stok wajib diproses dalam database transaction.

### 6.2 Aturan Jatuh Tempo
1. `tanggal_jatuh_tempo` secara default adalah 7 hari setelah `tanggal_pinjam`.
2. Admin tetap dapat menyesuaikan tanggal jatuh tempo bila ada kebijakan khusus.

### 6.3 Aturan Denda
1. Denda standar adalah **Rp2.000 per hari** keterlambatan.
2. Jika `tanggal_kembali` melewati `tanggal_jatuh_tempo`, sistem menghitung `jumlah_denda` berdasarkan selisih hari.
3. Jika buku belum dikembalikan dan hari ini melewati `tanggal_jatuh_tempo`, status berubah menjadi `terlambat`.
4. Nilai denda dapat ditampilkan otomatis, namun keputusan perubahan manual oleh admin perlu ditegaskan lagi pada tahap implementasi. Untuk saat ini, asumsi dasarnya adalah denda dihitung otomatis oleh sistem.

### 6.4 Aturan Status Peminjaman
1. `dipinjam`: buku sedang dipinjam dan belum melewati jatuh tempo.
2. `terlambat`: buku belum dikembalikan dan sudah melewati jatuh tempo.
3. `dikembalikan`: buku sudah dikembalikan.

---

## 7. Arah Implementasi Laravel

### 7.1 Pendekatan Aplikasi
1. Gunakan autentikasi Laravel standar.
2. Gunakan middleware dan policy untuk membatasi hak akses admin dan anggota.
3. Gunakan controller terpisah untuk area admin dan area anggota bila alur antarmuka berbeda.
4. Gunakan form request untuk validasi input.
5. Gunakan Eloquent relationship yang jelas antar model.

### 7.2 Komponen yang Diperkirakan Dibutuhkan
1. Model `User`
2. Model `Buku`
3. Model `Peminjaman`
4. Migration untuk penambahan kolom pada `users`
5. Migration tabel `buku`
6. Migration tabel `peminjaman`
7. Controller admin untuk buku, anggota, dan peminjaman
8. Controller anggota untuk katalog dan riwayat peminjaman
9. Policy untuk `Buku` dan `Peminjaman`
10. Scheduled command untuk pembaruan status keterlambatan

### 7.3 Scheduler
Perlu command Laravel yang berjalan harian untuk:
1. memeriksa data peminjaman yang melewati `tanggal_jatuh_tempo`,
2. mengubah `status_peminjaman` menjadi `terlambat`,
3. menghitung atau memperbarui `jumlah_denda` pada transaksi yang relevan.

---

## 8. Alur Implementasi yang Disarankan
Urutan kerja implementasi setelah PRD disetujui:

1. Rapikan skema migration agar sesuai dengan penamaan Indonesia.
2. Tambahkan kolom domain pada tabel `users`.
3. Buat model, relasi, dan factory yang diperlukan.
4. Implementasikan autentikasi dan pembagian peran `admin` dan `anggota`.
5. Bangun CRUD buku untuk admin.
6. Bangun modul transaksi peminjaman dan pengembalian.
7. Bangun halaman katalog dan riwayat peminjaman untuk anggota.
8. Tambahkan scheduler untuk keterlambatan dan denda.
9. Tambahkan pengujian fitur untuk alur utama.

---

## 9. Catatan Review Sebelum Implementasi
Hal-hal berikut sudah diputuskan dalam revisi PRD ini:

1. Filament dihapus dari rancangan.
2. Basis proyek mengikuti Laravel 13.
3. Penamaan tabel domain diubah ke bahasa Indonesia.
4. Penamaan kolom domain diubah ke bahasa Indonesia.
5. Tabel bawaan Laravel yang sudah ada tidak diubah namanya.

Hal yang masih bisa dikonfirmasi pada review berikutnya:

1. Apakah anggota boleh melakukan registrasi sendiri atau akun hanya dibuat admin.
2. Apakah denda boleh diubah manual oleh admin.
3. Apakah satu anggota boleh meminjam lebih dari satu buku pada waktu yang sama.
4. Apakah diperlukan fitur kategori buku, rak, atau laporan cetak pada fase awal.
