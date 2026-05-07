# Konsep Revisi Fitur Filter Usia & Rekomendasi Berdasarkan NIK

Dokumen ini menyusun konsep teknis untuk implementasi fitur pembatasan usia dan rekomendasi film berdasarkan data NIK pengguna.

## 1. Perubahan Basis Data

### Tabel `users`
Kita perlu menambahkan kolom baru untuk menyimpan data identitas dan kategori usia:
- `nik`: String (16 karakter), unik (untuk identitas).
- `birth_date`: Date, diinput saat registrasi (untuk penentuan usia).
- `age_category`: Enum ('anak', 'umum', 'dewasa'), dihitung berdasarkan `birth_date`.

### Tabel `movies`
Memastikan `age_rating` yang ada dipetakan ke 3 kategori utama:
- `Anak`: Rating G, PG, atau label 'SU', 'anak'.
- `Umum`: Rating PG-13 atau label '13+'.
- `Dewasa`: Rating R, NC-17 atau label '17+', '21+'.

---

## 2. Penentuan Kategori Usia

Kategori usia ditentukan berdasarkan selisih tahun antara `birth_date` dan waktu sekarang.

**Kategori Usia:**
- **Anak**: Usia < 13 tahun.
- **Umum**: Usia 13 - 17 tahun.
- **Dewasa**: Usia >= 18 tahun.

---

## 3. Fitur Utama

### A. Registrasi & Akun
- Menambahkan field `NIK` pada form registrasi atau profil.
- Validasi NIK (16 digit angka).
- Otomatis menghitung `birth_date` dan `age_category` saat menyimpan.

### B. Filter Rekomendasi (RecommendationService)
- Mengubah `RecommendationService.php` agar hanya mengambil film yang sesuai dengan `age_category` pengguna.
- **Hirarki Akses:**
    - Pengguna `Anak`: Hanya melihat film kategori `Anak` & `Umum`.
    - Pengguna `Umum`: Hanya melihat film kategori `Anak` & `Umum`.
    - Pengguna `Dewasa`: Melihat semua film.

### C. Kontrol Akses (Security)
- Implementasi Middleware `AgeAccessControl`.
- Jika pengguna `Anak` mencoba membuka URL film `Dewasa` secara langsung (via slug), sistem akan menampilkan pesan "Film ini tidak dapat diakses sesuai kategori usia Anda".

---

## 4. Alur Kerja Implementasi
1. **Migration**: Tambahkan kolom di tabel `users`.
2. **Helper/Service**: Buat logika parsing NIK.
3. **Controller/Auth**: Update proses registrasi & update profil.
4. **Service**: Update `RecommendationService` dengan filter usia.
5. **Middleware**: Buat middleware untuk proteksi akses detail film.
6. **UI Update**: Tampilkan label kategori usia pada profil dan film.

---
**Status:** Menunggu persetujuan untuk eksekusi kode.
