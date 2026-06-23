# 🚀 LOKALKARYA

<p align="center">
  <img src="https://lokalkarya.page.gd/images/logo.png" alt="Lokalkarya Logo" width="100%" style="border-radius: 20px; margin-bottom: 20px;" />
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite" />
  <img src="https://img.shields.io/badge/MySQL-00758F?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
</p>

---

## 🌟 Tentang Project

**LOKALKARYA** adalah platform digitalisasi pemasaran yang dirancang khusus untuk memfasilitasi mahasiswa dalam memasarkan **jasa kreatif** (seperti *UI/UX Design*, *Graphic Design*, *Video Editing*, *Photography*) serta **produk lokal** hasil karya mahasiswa di lingkungan kampus. 

Sistem ini bertindak sebagai inkubator kreatif dan jembatan penghubung antara mahasiswa kreatif (*Sellers*) dengan klien internal maupun eksternal kampus (*Clients*). Dilengkapi dengan alur verifikasi ketat oleh *Admin* untuk memastikan standar kualitas jasa dan produk yang dipasarkan tetap terjaga secara profesional.

---

## ✨ Fitur Utama

### 👥 Sistem Multi-Akses (Multi-Role Authentication)
* **Admin Workspace**: Dashboard khusus untuk memverifikasi akun seller baru dan menyaring kelayakan produk/jasa sebelum dipublikasikan di katalog utama.
* **Seller Workspace**: Dashboard mandiri untuk mengelola penawaran jasa, memperbarui status ketersediaan, merapikan portofolio, dan menyesuaikan nomor WhatsApp untuk diskusi langsung.
* **Client Interface**: Penjelajahan katalog publik secara responsif tanpa hambatan.

### 🎨 Fitur Kreator & Portofolio Dinamis
* **Direct Media Upload**: Pengunggahan foto profil dan gambar pendukung karya secara mulus.
* **Link Portofolio Eksternal**: Pengelolaan tautan menuju hasil karya di platform profesional (Behance, Dribbble, GitHub, Google Drive).
* **Kontak Instan WhatsApp**: Integrasi tombol chatting langsung menggunakan format `wa.me` tanpa perantara.

### 🔍 Navigasi & Filter Canggih
* **Smart Filter**: Pencarian berdasarkan kategori spesialisasi jasa.
* **Live Status**: Notifikasi visual status pembaruan profil yang elegan.

---

## 🛠️ Teknologi yang Digunakan

* **Backend & Logic**: Laravel Framework (PHP 8.3+)
* **Frontend styling**: Tailwind CSS (Modern Glassmorphism & Harmoni HSL)
* **Build tool**: Vite (HMR supercepat)
* **Database**: MySQL
* **Avatar Engine**: UI Avatars API

---

## 🚀 Panduan Instalasi & Setup Lokal

Ikuti langkah-langkah di bawah ini untuk menjalankan **LOKALKARYA** di server lokal Anda:

### Prasyarat (Prerequisites)
Pastikan Anda sudah menginstal alat-alat berikut di komputer Anda:
* PHP >= 8.2
* Composer
* Node.js & NPM
* MySQL / Laragon / XAMPP

---


## 📂 Struktur Folder Penting

* `app/Http/Controllers/` — Logika pengendali utama aplikasi (misal: `SellerProfileController`).
* `app/Models/` — Definisi relasi database (misal: `SellerProfile`, `User`).
* `database/migrations/` — Definisi skema tabel database.
* `resources/views/` — Desain antarmuka pengguna berbasis template Blade.
* `routes/web.php` — Definisi rute web aplikasi.

---

<p align="center">
  Dibuat dengan ❤️ oleh Mahasiswa untuk mendukung Ekosistem Kreatif Kampus.
</p>
