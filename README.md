Backend API untuk sistem manajemen vendor dan pemesanan barang PT. Maju Karya.

---

## 🚀 Tech Stack

- **Language:** PHP 8.x
- **Framework:** Laravel 12 (12.35.1)
- **Database:** MySQL
- **Authentication:** JWT (JSON Web Token) - tymon/jwt-auth

---

## ✨ Features

✅ **Authentication**
- Register, Login, Logout dengan JWT
- Protected routes dengan JWT middleware

✅ **CRUD Operations**
- Vendors Management
- Items Management
- Orders Management
- Vendor Items Management (untuk manage harga item per vendor)

✅ **Reporting System**
1. **Report Items by Vendor** - List item per vendor
2. **Report Vendor Ranking** - Ranking berdasarkan jumlah transaksi
3. **Report Price Rate Changes** - Perubahan harga dengan status up/down/stable

✅ **Additional**
- Input validation
- Database migrations
- Sample data seeder

---

## 📊 Database Schema

### Tables

**users** - User authentication
- id, name, email (unique), password, timestamps

**vendors** - Data vendor
- id_vendor (PK), kode_vendor (unique), nama_vendor, timestamps

**items** - Data item/barang
- id_item (PK), kode_item (unique), nama_item, timestamps

**orders** - Data transaksi pemesanan
- id_order (PK), tgl_order, no_order (unique), id_vendor (FK), id_item (FK), timestamps

**vendor_items** - Harga item per vendor
- id_vendor_item (PK), id_vendor (FK), id_item (FK), harga_sebelum, harga_sekarang, timestamps

---

## 🔧 Installation

### 1. Install Dependencies
```bash
cd majukarya
composer install
```

### 2. Setup Environment
Copy `.env.example` ke `.env` dan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=majukarya_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Generate Keys
```bash
php artisan key:generate
php artisan jwt:secret
```

### 4. Run Migrations & Seeder
```bash
php artisan migrate
php artisan db:seed
```

### 5. Start Server
```bash
php artisan serve
```
Server: **http://localhost:8000**

---

## 👤 Default Login

**Email:** `test@example.com`
**Password:** `password`

---

## 🔌 API Endpoints

### Public (No Auth)
- `POST /api/register` - Register
- `POST /api/login` - Login

### Protected (JWT Required)
- `POST /api/logout` - Logout
- `GET /api/me` - Get user info

**Vendors:**
- `GET /api/vendors` - List all
- `POST /api/vendors` - Create
- `GET /api/vendors/{id}` - Get one
- `PUT /api/vendors/{id}` - Update
- `DELETE /api/vendors/{id}` - Delete

**Items:**
- `GET /api/items` - List all
- `POST /api/items` - Create
- `GET /api/items/{id}` - Get one
- `PUT /api/items/{id}` - Update
- `DELETE /api/items/{id}` - Delete

**Orders:**
- `GET /api/orders` - List all
- `POST /api/orders` - Create
- `GET /api/orders/{id}` - Get one
- `PUT /api/orders/{id}` - Update
- `DELETE /api/orders/{id}` - Delete

**Vendor Items:**
- `GET /api/vendor-items` - List all (with prices)
- `POST /api/vendor-items` - Assign item to vendor with prices
- `GET /api/vendor-items/{id}` - Get one
- `PUT /api/vendor-items/{id}` - Update prices
- `DELETE /api/vendor-items/{id}` - Delete

**Reports:**
- `GET /api/reports/vendor-items` - Items by vendor
- `GET /api/reports/vendor-ranking` - Vendor ranking by transaction count
- `GET /api/reports/price-rate` - Price rate changes (up/down/stable)

---

## 🎯 Quick Start

### 1. Login
```bash
POST http://localhost:8000/api/login
Content-Type: application/json

{
    "email": "test@example.com",
    "password": "password"
}
```

Copy token dari response.

### 2. Test Report (with token)
```bash
GET http://localhost:8000/api/reports/vendor-ranking
Authorization: Bearer {your-token}
```

---

## 📦 Sample Data

Setelah `php artisan db:seed`:

**Users:** test@example.com (password: password)

**Vendors:** V01, V02, V03

**Items:** IT01, IT02, IT03

**Orders:**
- 30 orders dari V01
- 25 orders dari V02
- 20 orders dari V03

**Vendor Items:**
- V01 - IT01: 15000 → 10000 (down 33.33%)
- V01 - IT02: 25000 → 27000 (up 8%)
- V02 - IT03: 15000 → 15000 (stable)

---# majukarya
