# Struktur Database Website Company Profile

Berikut adalah rancangan tabel (*schema*) database relational (MySQL/PostgreSQL) yang dibutuhkan untuk mendukung fitur-fitur di halaman admin.

## 1. Tabel `users` (Manajemen Akun Admin)

Menyimpan data pengguna yang memiliki akses ke halaman admin.

| Kolom | Tipe Data | Keterangan | 
| ----- | ----- | ----- | 
| `id` | BIGINT (PK) | Auto Increment | 
| `name` | VARCHAR(255) | Nama pengguna admin | 
| `email` | VARCHAR(255) | Email untuk login (Unique) | 
| `password` | VARCHAR(255) | Password (Hashed) | 
| `role` | ENUM | Pilihan: 'superadmin', 'admin', 'writer' | 
| `created_at` | TIMESTAMP | Waktu data dibuat | 
| `updated_at` | TIMESTAMP | Waktu data diperbarui | 

## 2. Tabel `settings` (Pengaturan Perusahaan)

Menggunakan konsep *Key-Value pair* agar lebih fleksibel saat ada penambahan pengaturan baru tanpa harus mengubah struktur tabel.

| Kolom | Tipe Data | Keterangan | 
| ----- | ----- | ----- | 
| `id` | BIGINT (PK) | Auto Increment | 
| `key` | VARCHAR(100) | Kunci pengaturan (Contoh: `company_name`, `logo`, `about`, `whatsapp`, `address`) (Unique) | 
| `value` | TEXT | Nilai dari pengaturan tersebut | 
| `type` | VARCHAR(50) | Tipe data input (Contoh: `text`, `image`, `textarea`, `url`) | 
| `updated_at` | TIMESTAMP | Waktu pengaturan terakhir diubah | 

## 3. Tabel `services` (Layanan/Jasa)

Menyimpan daftar layanan yang ditawarkan oleh perusahaan.

| Kolom | Tipe Data | Keterangan | 
| ----- | ----- | ----- | 
| `id` | BIGINT (PK) | Auto Increment | 
| `title` | VARCHAR(255) | Nama layanan | 
| `slug` | VARCHAR(255) | URL-friendly nama layanan (Unique) | 
| `description` | TEXT | Penjelasan detail layanan | 
| `icon_or_image` | VARCHAR(255) | Path file gambar atau nama class icon | 
| `created_at` | TIMESTAMP | \- | 
| `updated_at` | TIMESTAMP | \- | 

## 4. Tabel `clients` (Klien / Mitra)

Menyimpan logo dan nama klien untuk ditampilkan di *slider* atau *grid* klien.

| Kolom | Tipe Data | Keterangan | 
| ----- | ----- | ----- | 
| `id` | BIGINT (PK) | Auto Increment | 
| `name` | VARCHAR(255) | Nama klien/perusahaan mitra | 
| `logo` | VARCHAR(255) | Path file logo klien | 
| `website_url` | VARCHAR(255) | Link website klien (Nullable) | 
| `created_at` | TIMESTAMP | \- | 
| `updated_at` | TIMESTAMP | \- | 

## 5. Tabel `projects` (Portofolio)

Menyimpan data proyek yang pernah dikerjakan.

| Kolom | Tipe Data | Keterangan | 
| ----- | ----- | ----- | 
| `id` | BIGINT (PK) | Auto Increment | 
| `client_id` | BIGINT (FK) | Relasi ke tabel `clients` (Nullable) | 
| `title` | VARCHAR(255) | Nama proyek / portofolio | 
| `slug` | VARCHAR(255) | URL-friendly (Unique) | 
| `description` | TEXT | Penjelasan tentang proyek tersebut | 
| `completion_date` | DATE | Tanggal proyek selesai | 
| `created_at` | TIMESTAMP | \- | 
| `updated_at` | TIMESTAMP | \- | 

## 6. Tabel `project_images` (Galeri Proyek)

Menyimpan banyak gambar untuk satu proyek (Relasi *One-to-Many* dengan tabel `projects`).

| Kolom | Tipe Data | Keterangan | 
| ----- | ----- | ----- | 
| `id` | BIGINT (PK) | Auto Increment | 
| `project_id` | BIGINT (FK) | Relasi ke tabel `projects` (Cascade on Delete) | 
| `image_path` | VARCHAR(255) | Path file gambar | 
| `is_primary` | BOOLEAN | Menandakan ini sebagai thumbnail utama proyek | 
| `created_at` | TIMESTAMP | \- | 

## 7. Tabel `categories` (Kategori Artikel)

Mengelompokkan artikel atau berita ke dalam beberapa kategori.

| Kolom | Tipe Data | Keterangan | 
| ----- | ----- | ----- | 
| `id` | BIGINT (PK) | Auto Increment | 
| `name` | VARCHAR(100) | Nama kategori | 
| `slug` | VARCHAR(100) | URL-friendly (Unique) | 
| `created_at` | TIMESTAMP | \- | 
| `updated_at` | TIMESTAMP | \- | 

## 8. Tabel `posts` (Artikel / Blog)

Menyimpan konten berita atau artikel SEO.

| Kolom | Tipe Data | Keterangan | 
| ----- | ----- | ----- | 
| `id` | BIGINT (PK) | Auto Increment | 
| `category_id` | BIGINT (FK) | Relasi ke tabel `categories` (Nullable) | 
| `user_id` | BIGINT (FK) | Penulis artikel, relasi ke tabel `users` | 
| `title` | VARCHAR(255) | Judul artikel | 
| `slug` | VARCHAR(255) | URL-friendly (Unique) | 
| `content` | LONGTEXT | Isi artikel (format HTML dari Rich Text Editor) | 
| `thumbnail` | VARCHAR(255) | Gambar utama (*cover*) artikel | 
| `status` | ENUM | Pilihan: 'draft', 'published' | 
| `published_at` | DATETIME | Waktu tayang artikel (bisa untuk fitur *schedule*) | 
| `created_at` | TIMESTAMP | \- | 
| `updated_at` | TIMESTAMP | \- | 

## 9. Tabel `testimonials` (Ulasan Klien)

Menyimpan umpan balik dari klien.

| Kolom | Tipe Data | Keterangan | 
| ----- | ----- | ----- | 
| `id` | BIGINT (PK) | Auto Increment | 
| `name` | VARCHAR(255) | Nama orang yang memberikan testimoni | 
| `position` | VARCHAR(255) | Jabatan / Asal Instansi | 
| `message` | TEXT | Isi testimoni | 
| `image` | VARCHAR(255) | Foto orang tersebut (Nullable) | 
| `created_at` | TIMESTAMP | \- | 
| `updated_at` | TIMESTAMP | \- | 

## 10. Tabel `teams` (Manajemen Tim)

Menyimpan profil singkat direksi atau tim perusahaan.

| Kolom | Tipe Data | Keterangan | 
| ----- | ----- | ----- | 
| `id` | BIGINT (PK) | Auto Increment | 
| `name` | VARCHAR(255) | Nama anggota tim | 
| `position` | VARCHAR(255) | Jabatan (Contoh: CEO, Direktur) | 
| `photo` | VARCHAR(255) | Path file foto anggota tim | 
| `linkedin_url` | VARCHAR(255) | Link LinkedIn (Nullable) | 
| `created_at` | TIMESTAMP | \- | 
| `updated_at` | TIMESTAMP | \- | 

## 11. Tabel `contact_leads` (Data Prospek/Kontak)

Tabel ini digunakan untuk **menyimpan data secara diam-diam** (sebagai *backup*) sesaat sebelum pengunjung di-*redirect* ke WhatsApp.

| Kolom | Tipe Data | Keterangan | 
| ----- | ----- | ----- | 
| `id` | BIGINT (PK) | Auto Increment | 
| `name` | VARCHAR(255) | Nama pengunjung dari Form | 
| `company` | VARCHAR(255) | Asal perusahaan pengunjung | 
| `message` | TEXT | Isi pesan dari Form | 
| `is_followed_up` | BOOLEAN | Default FALSE (Bisa dicentang di Admin Panel jika sudah dihubungi) | 
| `created_at` | TIMESTAMP | Waktu form disubmit | 
| `updated_at` | TIMESTAMP | \- | 

## 12. Tabel `visitors` (Pelacakan Pengunjung)

Tabel ini digunakan untuk mencatat riwayat kunjungan pengguna untuk keperluan statistik di *dashboard*.

| Kolom | Tipe Data | Keterangan | 
| ----- | ----- | ----- | 
| `id` | BIGINT (PK) | Auto Increment | 
| `ip_address` | VARCHAR(45) | Alamat IP pengunjung (IPv4 atau IPv6) | 
| `user_agent` | TEXT | Informasi sistem operasi, *device*, dan *browser* pengunjung | 
| `session_id` | VARCHAR(255) | ID Sesi unik (berguna untuk menghitung Unique Visitor dalam sehari) | 
| `visited_url` | VARCHAR(255) | Halaman / URL spesifik yang sedang dikunjungi | 
| `created_at` | TIMESTAMP | Waktu halaman diakses | 
| `updated_at` | TIMESTAMP | \- | 

## 13. Tabel `sliders` (Manajemen Banner/Slider)

Menyimpan gambar-gambar besar (*hero banner*) yang berganti-ganti di halaman depan.

| Kolom | Tipe Data | Keterangan | 
| ----- | ----- | ----- | 
| `id` | BIGINT (PK) | Auto Increment | 
| `title` | VARCHAR(255) | Judul teks di atas banner | 
| `subtitle` | TEXT | Teks subjudul / deskripsi singkat (Nullable) | 
| `image_path` | VARCHAR(255) | Path file gambar banner | 
| `button_text` | VARCHAR(100) | Teks pada tombol (Contoh: "Lihat Promo") (Nullable) | 
| `button_url` | VARCHAR(255) | Tautan tujuan jika tombol diklik (Nullable) | 
| `order` | INT | Urutan kemunculan banner | 
| `is_active` | BOOLEAN | Status aktif/tidaknya banner ini | 
| `created_at` | TIMESTAMP | \- | 
| `updated_at` | TIMESTAMP | \- | 

## 14. Tabel `faqs` (Frequently Asked Questions)

Menyimpan daftar tanya-jawab umum tentang perusahaan.

| Kolom | Tipe Data | Keterangan | 
| ----- | ----- | ----- | 
| `id` | BIGINT (PK) | Auto Increment | 
| `question` | VARCHAR(255) | Pertanyaan | 
| `answer` | TEXT | Jawaban | 
| `order` | INT | Urutan kemunculan | 
| `is_active` | BOOLEAN | Menampilkan atau menyembunyikan FAQ ini | 
| `created_at` | TIMESTAMP | \- | 
| `updated_at` | TIMESTAMP | \- | 

## 15. Tabel `pages` (Halaman Statis Dinamis)

Menyimpan halaman panjang yang dibuat khusus (seperti Kebijakan Privasi, Tentang Kami, dll).

| Kolom | Tipe Data | Keterangan | 
| ----- | ----- | ----- | 
| `id` | BIGINT (PK) | Auto Increment | 
| `title` | VARCHAR(255) | Judul halaman | 
| `slug` | VARCHAR(255) | URL-friendly (Unique) | 
| `content` | LONGTEXT | Isi lengkap halaman (Format HTML) | 
| `meta_description`| TEXT | Deskripsi singkat untuk keperluan SEO Google (Nullable) | 
| `created_at` | TIMESTAMP | \- | 
| `updated_at` | TIMESTAMP | \- | 

## 16. Tabel `subscribers` (Pengikut Newsletter)

Menyimpan email pengunjung yang mendaftar untuk mendapatkan *update* atau promo perusahaan.

| Kolom | Tipe Data | Keterangan | 
| ----- | ----- | ----- | 
| `id` | BIGINT (PK) | Auto Increment | 
| `email` | VARCHAR(255) | Alamat email pengunjung (Unique) | 
| `created_at` | TIMESTAMP | Waktu pengunjung mendaftar | 
| `updated_at` | TIMESTAMP | \- | 

## 17. Tabel `activity_logs` (Riwayat Aktivitas Admin)

Mencatat siapa saja yang melakukan perubahan (tambah, edit, hapus) di halaman admin.

| Kolom | Tipe Data | Keterangan | 
| ----- | ----- | ----- | 
| `id` | BIGINT (PK) | Auto Increment | 
| `user_id` | BIGINT (FK) | User admin yang melakukan aksi (Nullable) | 
| `action_type` | VARCHAR(100) | Jenis aksi: 'created', 'updated', 'deleted' | 
| `model_type` | VARCHAR(255) | Bagian/Tabel yang diubah (Misal: `App\Models\Post`) | 
| `model_id` | BIGINT | ID dari data yang diubah | 
| `description` | TEXT | Keterangan detail perubahan data | 
| `created_at` | TIMESTAMP | Waktu aktivitas dilakukan | 
| `updated_at` | TIMESTAMP | \- | 