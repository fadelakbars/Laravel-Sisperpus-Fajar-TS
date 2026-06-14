# Rencana Implementasi Sistem Perpustakaan
## Proyek `laravel-sisperpus`

---

## 1. Tujuan Dokumen
Dokumen ini menjadi panduan kerja implementasi setelah PRD disetujui. Fokusnya adalah memecah pekerjaan menjadi fase yang kecil, jelas, dan aman untuk dikerjakan bertahap.

Kondisi dasar saat dokumen ini dibuat:
1. PRD final sudah disetujui.
2. Migration bawaan Laravel sudah dijalankan.
3. Implementasi domain perpustakaan belum dimulai.

---

## 2. Prinsip Implementasi
1. Implementasi dilakukan bertahap, bukan sekaligus.
2. Setiap fase harus selesai dalam kondisi tetap rapi dan mudah diuji.
3. Penamaan tabel dan kolom domain wajib menggunakan bahasa Indonesia.
4. Tabel bawaan Laravel yang sudah ada tidak diubah namanya.
5. Setiap fase sebaiknya diakhiri dengan review kode dan update checklist.

---

## 3. Urutan Fase Pekerjaan

### Fase 1: Fondasi Database Domain
Fokus:
1. Menambah kolom domain pada tabel `users`
2. Membuat migration tabel `buku`
3. Membuat migration tabel `peminjaman`
4. Memastikan foreign key, index, enum status, dan default value sesuai PRD

Output:
1. Struktur database domain siap dipakai
2. Naming tabel dan kolom sudah sesuai PRD

Catatan:
1. Fase ini hanya menyentuh migration
2. Belum masuk ke controller, Blade, atau autentikasi

### Fase 2: Model, Relasi, dan Factory
Fokus:
1. Update model `User` untuk kebutuhan domain perpustakaan
2. Membuat model `Buku`
3. Membuat model `Peminjaman`
4. Menambahkan relasi Eloquent
5. Menambahkan cast dan atribut default yang diperlukan
6. Menyiapkan factory dasar untuk test dan seeder

Output:
1. Fondasi Eloquent siap dipakai
2. Data dummy dasar dapat dibuat dengan factory

### Fase 3: Seeder dan Data Awal
Fokus:
1. Menyiapkan akun admin awal
2. Menyiapkan anggota contoh
3. Menyiapkan data buku contoh

Output:
1. Proyek punya data awal untuk pengujian manual

### Fase 4: Autentikasi dan Pembagian Peran
Fokus:
1. Menentukan alur login sederhana berbasis session
2. Menyiapkan pembagian area admin dan anggota
3. Menambahkan middleware atau gate dasar untuk admin
4. Menentukan redirect setelah login berdasarkan peran

Output:
1. Akses admin dan anggota mulai terpisah

Catatan:
1. Registrasi mandiri anggota belum diputuskan di PRD
2. Untuk fase awal, asumsi akun anggota dibuat admin

### Fase 5: Modul Admin Buku
Fokus:
1. CRUD buku
2. Validasi input buku
3. Halaman daftar, tambah, ubah, hapus
4. Pencarian sederhana katalog buku

Output:
1. Admin bisa mengelola katalog buku

### Fase 6: Modul Admin Anggota
Fokus:
1. CRUD anggota
2. Validasi akun anggota
3. Penetapan `peran = anggota`

Output:
1. Admin bisa mengelola akun anggota perpustakaan

### Fase 7: Modul Admin Peminjaman
Fokus:
1. Membuat transaksi peminjaman
2. Mengurangi stok otomatis
3. Menolak peminjaman saat stok habis
4. Menampilkan daftar peminjaman
5. Memproses pengembalian
6. Mengembalikan stok otomatis
7. Menghitung denda saat pengembalian

Output:
1. Alur sirkulasi inti berjalan

Catatan:
1. Logika stok dan peminjaman harus dibungkus database transaction
2. Sangat disarankan dipisah ke action atau service class

### Fase 8: Modul Anggota
Fokus:
1. Halaman dashboard anggota
2. Katalog buku untuk anggota
3. Pencarian buku
4. Riwayat peminjaman pribadi
5. Status denda pribadi

Output:
1. Anggota bisa melihat data yang relevan untuk dirinya

### Fase 9: Scheduler Keterlambatan
Fokus:
1. Membuat command untuk memeriksa keterlambatan
2. Mengubah status menjadi `terlambat`
3. Memperbarui `jumlah_denda`
4. Menjadwalkan command harian

Output:
1. Denda dan status keterlambatan dapat diperbarui otomatis

### Fase 10: Pengujian
Fokus:
1. Test migration dan relasi dasar
2. Test hak akses admin dan anggota
3. Test CRUD buku
4. Test transaksi peminjaman
5. Test pengembalian dan denda
6. Test command keterlambatan

Output:
1. Alur utama terlindungi oleh test fitur

---

## 4. Strategi Eksekusi Bertahap
Urutan implementasi yang disarankan untuk sesi coding:

1. Fase 1 terlebih dahulu
2. Review hasil migration
3. Fase 2
4. Review model dan relasi
5. Fase 3
6. Fase 4
7. Fase 5 sampai Fase 9 secara bertahap
8. Fase 10 setelah alur inti stabil

Pendekatan ini dipilih agar:
1. struktur data final lebih dulu,
2. logic bisnis dibangun di atas schema yang sudah tetap,
3. risiko refactor besar di tengah implementasi bisa dikurangi.

---

## 5. Risiko yang Harus Dijaga
1. Salah naming tabel atau kolom yang bertentangan dengan PRD
2. Logic stok tidak konsisten saat peminjaman atau pengembalian
3. Hak akses admin dan anggota tercampur
4. Denda dihitung di banyak tempat tanpa sumber logika tunggal
5. Terlalu cepat membangun UI sebelum model dan alur bisnis stabil

---

## 6. Rekomendasi Sesi Berikutnya
Sesi coding berikutnya sebaiknya dimulai dari:
1. membuat migration domain perpustakaan,
2. menjalankan migration,
3. review hasil struktur database,
4. baru lanjut ke model dan relasi.
