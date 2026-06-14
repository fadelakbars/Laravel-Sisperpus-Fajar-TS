# Todo Implementasi Sistem Perpustakaan

Gunakan checklist ini sebagai tracker pekerjaan implementasi.

Status awal:
1. PRD selesai
2. Migration bawaan Laravel sudah dijalankan
3. Implementasi domain perpustakaan belum dimulai

---

## A. Fondasi Database
- [ ] Tambah kolom `nim` pada tabel `users`
- [ ] Tambah kolom `peran` pada tabel `users`
- [ ] Buat migration tabel `buku`
- [ ] Tambahkan kolom `isbn`
- [ ] Tambahkan kolom `judul`
- [ ] Tambahkan kolom `penulis`
- [ ] Tambahkan kolom `penerbit`
- [ ] Tambahkan kolom `tahun_terbit`
- [ ] Tambahkan kolom `stok`
- [ ] Tambahkan kolom `lokasi_rak`
- [ ] Buat migration tabel `peminjaman`
- [ ] Tambahkan kolom `anggota_id`
- [ ] Tambahkan kolom `buku_id`
- [ ] Tambahkan kolom `tanggal_pinjam`
- [ ] Tambahkan kolom `tanggal_jatuh_tempo`
- [ ] Tambahkan kolom `tanggal_kembali`
- [ ] Tambahkan kolom `jumlah_denda`
- [ ] Tambahkan kolom `status_peminjaman`
- [ ] Tambahkan foreign key dan index yang diperlukan
- [ ] Jalankan migration domain
- [ ] Review struktur database hasil migration

## B. Model dan Relasi
- [ ] Update model `User`
- [ ] Buat model `Buku`
- [ ] Buat model `Peminjaman`
- [ ] Tambahkan relasi `User -> peminjaman`
- [ ] Tambahkan relasi `Buku -> peminjaman`
- [ ] Tambahkan relasi `Peminjaman -> anggota`
- [ ] Tambahkan relasi `Peminjaman -> buku`
- [ ] Tambahkan cast yang diperlukan
- [ ] Tambahkan default attribute yang diperlukan

## C. Factory dan Seeder
- [ ] Update `UserFactory`
- [ ] Buat `BukuFactory`
- [ ] Buat `PeminjamanFactory`
- [ ] Update `DatabaseSeeder`
- [ ] Buat akun admin awal
- [ ] Buat anggota contoh
- [ ] Buat data buku contoh

## D. Autentikasi dan Peran
- [ ] Tentukan alur login berbasis session
- [ ] Buat form login
- [ ] Buat proses login
- [ ] Buat proses logout
- [ ] Buat redirect berdasarkan peran
- [ ] Tambahkan pembatas akses admin
- [ ] Tambahkan pembatas akses anggota

## E. Modul Admin Buku
- [ ] Buat route admin buku
- [ ] Buat controller buku
- [ ] Buat request validasi buku
- [ ] Buat halaman daftar buku
- [ ] Buat halaman tambah buku
- [ ] Buat halaman edit buku
- [ ] Buat aksi hapus buku
- [ ] Tambahkan pencarian buku

## F. Modul Admin Anggota
- [ ] Buat route admin anggota
- [ ] Buat controller anggota
- [ ] Buat request validasi anggota
- [ ] Buat halaman daftar anggota
- [ ] Buat halaman tambah anggota
- [ ] Buat halaman edit anggota
- [ ] Buat aksi hapus anggota

## G. Modul Admin Peminjaman
- [ ] Buat route admin peminjaman
- [ ] Buat controller peminjaman
- [ ] Buat request validasi peminjaman
- [ ] Buat halaman daftar peminjaman
- [ ] Buat halaman tambah peminjaman
- [ ] Buat logic kurangi stok saat pinjam
- [ ] Tolak peminjaman jika stok habis
- [ ] Buat aksi pengembalian buku
- [ ] Buat logic tambah stok saat kembali
- [ ] Hitung denda saat pengembalian
- [ ] Bungkus proses peminjaman dalam database transaction
- [ ] Bungkus proses pengembalian dalam database transaction

## H. Modul Anggota
- [ ] Buat dashboard anggota
- [ ] Buat halaman katalog buku
- [ ] Tambahkan pencarian katalog
- [ ] Buat halaman riwayat peminjaman pribadi
- [ ] Tampilkan status keterlambatan
- [ ] Tampilkan jumlah denda pribadi

## I. Policy dan Otorisasi
- [ ] Buat `BukuPolicy`
- [ ] Buat `PeminjamanPolicy`
- [ ] Daftarkan policy yang diperlukan
- [ ] Pastikan admin punya akses penuh sesuai PRD
- [ ] Pastikan anggota hanya bisa melihat data miliknya

## J. Scheduler dan Command
- [ ] Buat command update keterlambatan
- [ ] Ubah status peminjaman menjadi `terlambat`
- [ ] Perbarui `jumlah_denda` otomatis
- [ ] Daftarkan schedule harian
- [ ] Review hasil command manual

## K. Testing
- [ ] Buat test migration atau struktur alur penting
- [ ] Buat test login
- [ ] Buat test hak akses admin
- [ ] Buat test hak akses anggota
- [ ] Buat test CRUD buku
- [ ] Buat test tambah anggota
- [ ] Buat test peminjaman berhasil
- [ ] Buat test peminjaman gagal saat stok habis
- [ ] Buat test pengembalian buku
- [ ] Buat test kalkulasi denda
- [ ] Buat test command keterlambatan
- [ ] Jalankan `php artisan test --compact`

## L. Finishing
- [ ] Jalankan `vendor/bin/pint --dirty --format agent`
- [ ] Review manual lewat browser
- [ ] Pastikan route utama berjalan
- [ ] Pastikan tidak ada error log utama
- [ ] Commit bertahap per fase
