# Rencana Perbaikan UI/UX - Sisperpus (Light Mode)

Dokumen ini merinci langkah-langkah transformasi antarmuka pengguna (UI) dan pengalaman pengguna (UX) untuk aplikasi Sisperpus (Sisperpus), berpindah dari estetika gelap ke tema **Minimalis, Modern, Clean, dan Light Mode**.

## 1. Visi Desain
*   **Minimalis:** Menghilangkan elemen visual yang tidak perlu untuk fokus pada konten.
*   **Modern:** Menggunakan spasi yang lega (white space), sudut membulat yang halus, dan tipografi kontemporer.
*   **Clean:** Palet warna yang bersih dengan kontras yang pas untuk keterbacaan tinggi.
*   **Light Mode:** Dominasi warna putih dan abu-abu sangat muda dengan aksen warna Indigo/Blue.

## 2. Palet Warna & Tipografi
*   **Background:** `bg-slate-50` (Halaman) / `bg-white` (Card/Sidebar).
*   **Primary:** `indigo-600` (Brand/Action) / `indigo-700` (Hover).
*   **Text:** `slate-900` (Headings) / `slate-600` (Body).
*   **Border:** `slate-200`.
*   **Aksentuasi:** 
    *   Sukses: `emerald-600`
    *   Bahaya: `rose-600`
    *   Peringatan/Denda: `amber-500`
*   **Tipografi:** `Instrument Sans` (Bawaan) dengan fallback `Inter`.

## 3. Arsitektur Komponen (Sisperpus UI Kit)
Membangun library komponen Blade untuk konsistensi:
*   `x-ui.layout.app`: Layout utama dengan Sidebar yang menetap.
*   `x-ui.button`: Komponen tombol dengan varian `primary`, `secondary`, `ghost`, dan `danger`.
*   `x-ui.input`: Field input dengan label, helper text, dan state error yang standar.
*   `x-ui.table`: Standarisasi tampilan tabel data dengan header yang bersih.
*   `x-ui.badge`: Label status (Tersedia, Terlambat, dll).
*   `x-ui.card`: Kontainer konten dengan shadow halus (`shadow-sm`).

## 4. Tahapan Implementasi
1.  **Tahap 1:** Fondasi & Layout Utama (Sidebar & Navigation).
2.  **Tahap 2:** Standardisasi Komponen UI Kit.
3.  **Tahap 3:** Redesain Halaman Auth (Login).
4.  **Tahap 4:** Transformasi Dashboard & CRUD (Admin & Anggota).

## 5. Alur Kerja Git
Setiap perubahan unit kerja akan diikuti dengan:
1. `git add` & `git commit`
2. `git push origin main`
