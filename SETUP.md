# 🚀 Panduan Setup Proyek Puskesmas (CodeIgniter 4 + TailwindCSS)

Ini adalah panduan singkat untuk mengatur ulang proyek Puskesmas dari awal setelah clone repository.

---

## ✅ Persyaratan Awal

Pastikan sudah install:

- PHP ≥ 8.1
- Composer
- Node.js & npm
- MySQL/MariaDB
- Git

---

## 🛠️ Langkah-langkah Setup

### 1. Clone Repositori

```bash
git clone https://github.com/agilbiaviv/webpkm.git
cd webpkm
```

---

### 2. Install Dependency Backend

```bash
composer install
```

---

### 3. Install Dependency Frontend

```bash
npm install
```

Untuk development (tailwind live reload):

```bash
npm run tailwind
```

📌📌 Pastikan script diatas selalu dijalankan saat development!


Generate file app.js untuk frontend dengan :
```bash
npm run buildJS
```


---

### 4. Buat dan Atur File .env

```bash
cp env .env
```

ATAU

copy dan rename file `env` menjadi `.env` 

Edit `.env` dan sesuaikan konfigurasi database dan baseURL:

```env
database.default.hostname = localhost
database.default.database = webpkm
database.default.username = root
database.default.password =
app.baseURL = http://localhost:8080/
```

---

### 5. Buat Database

Buat database secara manual (via phpMyAdmin atau MySQL CLI):

```sql
CREATE DATABASE webpkm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

### 6. Jalankan Migration

```bash
php spark migrate
```

---

### 7. Jalankan Seeder (Opsional)

```bash
php spark db:seed UserSeeder
```

---

### 8. Jalankan Server Lokal (Opsional)

```bash
php spark serve
```

---

## ✅ Proyek Siap Digunakan!

Akses via browser:

```
http://localhost:8080
```

---

Happy coding! ✨
