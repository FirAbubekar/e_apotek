# Standar Pengembangan e-Apotek

Dokumen ini berisi aturan baku (coding standards) untuk pengembangan aplikasi e-Apotek. Semua implementasi kode harus mengikuti pedoman di bawah ini.

## 1. Arsitektur: "Skinny Controller, Fat Service"
Pemisahan tanggung jawab kode adalah hal wajib.
- **Controller** hanya boleh bertanggung jawab untuk logika HTTP:
  - Menerima `Request`.
  - Memanggil validasi.
  - Memanggil **Service** untuk memproses data.
  - Mengembalikan `Response` (View atau JSON, redirect dengan Session Message).
- **Service Classes** (`app/Services/`) wajib digunakan untuk logika bisnis yang kompleks:
  - Menyimpan transaksi (misal: memotong stok sekaligus mencatat riwayat mutasi).
  - Kalkulasi harga, diskon, dan pajak.
  - Setiap Service bertanggung jawab penuh terhadap satu entitas/proses bisnis (contoh: `SalesService`, `StockService`).
- **Model** hanya berisi deklarasi tabel, `fillable`, relasi (`belongsTo`, `hasMany`), `scopes`, serta accessor/mutator yang sangat sederhana.

## 2. Penanganan Error (Error Handling) & Transaksi
### Di Level Backend (PHP):
- Operasi tulis (Write/Update/Delete) yang berisiko atau melibatkan lebih dari 1 tabel **WAJIB dibungkus dengan `DB::beginTransaction()`**.
- Gunakan blok `try...catch` di dalam Service atau Controller.
- Saat terjadi error/Exception dalam blok `catch`:
  1. Lakukan `DB::rollBack()`.
  2. Catat error secara rahasia di log menggunakan `Log::error($e->getMessage())`.
  3. Lemparkan kembali (*rethrow*) exeception yang lebih dimengerti oleh user, atau kembalikan response dengan pesan yang ramah (*user-friendly*). Jangan pernah membocorkan *SQL Exception* ke layar pengguna akhir!

### Di Level Frontend (Blade & UI):
- **Tampilan Feedback (Flash Messages):**
  - Berikan umpan balik instan untuk setiap modifikasi data (sukses atau gagal) menggunakan `session('success')` atau `session('error')`.
  - Gunakan `alert` UI yang sudah ada di layout.
- **Validasi Form:**
  - Tampilkan error tepat di bawah input field dengan tag `<div class="text-danger">` jika validasi server-side gagal.
  - Pasang validasi *client-side* (tag `required`, `type="number"`, dll) di layer HTML sebagai pertahanan pertama.

## 3. Tampilan Halaman Error Standar (Custom View)
- Aplikasi harus menampilkan halaman error kostum yang sudah dirancang agar serasi dengan antarmuka utama.
- Layar error untuk *HTTP Status Codes*:
  - **404:** Halaman Tidak Ditemukan.
  - **500:** Internal Server Error (Misalnya ada `try...catch` yang sangat fatal terlewat).
  - **403:** Akses Ditolak (Unauthorized) - untuk pembatasan Hak Akses/Role.
- File-file ini berada di direktori `resources/views/errors/` dan memanfaatkan `layouts.app` atau desain minimalis yang selaras dengan palet warnanya (Teal/Emerald).
