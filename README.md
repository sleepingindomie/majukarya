
## Installation

### 1. Install Dependencies
```bash
cd majukarya
composer install
```

### 2. Setup Environment
```bash
cp .env.example .env
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

## Default Login

**Email:** `test@example.com`
**Password:** `password`

---

## API Endpoints

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
