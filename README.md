# Lab Reservation System

Website reservasi Lab Komputer berbasis PHP Native dengan fitur autentikasi, OTP email, reservasi jadwal, cek jadwal, dan dashboard admin.

---

# Features

## User Features

- Registrasi Akun
- Login & Logout
- Lupa Password
- Verifikasi OTP Email
- Reset Password
- Reservasi Lab
- Riwayat Reservasi
- Cek Status Reservasi
- Lihat Jadwal Lab
- Fitur Notifikasi 

## Admin Features

- Dashboard Statistik
- Kelola Reservasi
- Riwayat Reservasi
- Manajemen Operasional Lab

---

# Tech Stack

## Backend

* PHP Native
* MySQL
* Composer
* PHPMailer

## Frontend

* Tailwind CSS
* JavaScript
* Flatpickr
* AOS
* CropperJS
* Lucide Icons

---

# Security Features

* Session Authentication
* Password Hashing
* Email Verification Token
* Reset Password Token
* OTP Email Verification
* Prepared Statements
* Role-Based Access Control
* Secure Password Reset

---

# Installation

## 1. Clone Repository

```bash
git clone https://github.com/Lodi7/Sistem-Reservasi-Ruangan.git
```

---

## 2. Masuk Folder Project

```bash
cd Sistem-Reservasi-Ruangan
```

---

## 3. Install Dependency Composer

```bash
composer install
```

---

## 4. Install Dependency Node.js

```bash
npm install
```

---

## 5. Buat File .env

Copy file `.env.examples` menjadi `.env`

### Windows CMD

```bash
copy .env.examples .env
```

### Git Bash / Linux

```bash
cp .env.examples .env
```

---

## 6. Isi Konfigurasi `.env`

Contoh:

```env
DB_HOST=localhost
DB_PORT=
DB_NAME=db_ruangan
DB_USER=
DB_PASS=

MAIL_USERNAME=example@gmail.com
MAIL_PASSWORD=yourpassword
```

---

## 7. Import Database

Import file SQL ke phpMyAdmin.

Contoh:
- buka phpMyAdmin
- buat database `db_ruangan`
- import file `.sql`

---

# Running Project

## Jalankan PHP

Jika menggunakan XAMPP:
- pindahkan project ke folder `htdocs`
- jalankan Apache & MySQL

Akses:

```txt
http://localhost/name-project
```

Jika menggunakan Laragon:
- pindahkan project ke folder `laragon/www`
- jalankan Apache & MySQL

Akses:

```txt
http://Sistem-Reservasi-Ruangan.test
```


---

## Jalankan Tailwind CSS

```bash
npm run dev
```

Atau manual:

```bash
npx tailwindcss -i ./assets/css/input.css -o ./assets/css/output.css --watch
```

---

# Default Roles

## Mahasiswa & Dosen
- Login menggunakan email mahasiswa/dosen milik UPN
- Melakukan reservasi lab komputer
- Melihat riwayat reservasi
- Melihat Jadwal yang tersedia

## Admin
- Mengelola lab komputer
- Mengelola reservasi
- Validasi jadwal

---

# .gitignore

```gitignore
.env
/vendor/
/node_modules/
```

---

# Preview

| Home | Login |
|---|---|
| ![](assets/screenshots/beranda.png) | ![](assets/screenshots/login.png) |

# License

This project is for educational purposes.
