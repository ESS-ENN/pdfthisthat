# 🛠️ Operations Guide for pdfthisthat.com

This document provides the operational procedures and environment-specific details for running and maintaining the **pdfthisthat.com** Laravel application hosted using **XAMPP (Apache, MySQL)**.

---

## 📦 Project Stack

- **Framework**: Laravel (PHP)
- **Server**: Apache (via XAMPP)
- **Database**: MySQL
- **PHP Version**: 8.x recommended
- **OS**: Windows (for local), Linux (for production)
- **Frontend**: Blade / Vue / Tailwind CSS (as applicable)

---

## 🚀 Local Setup (XAMPP)

### Prerequisites

- XAMPP (with Apache & MySQL)
- Composer
- Node.js & NPM
- Git (optional)

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/kchecker/pdfthisthat.git
   cd pdfthisthat.com

2. **Install PHP dependencies**
    composer install

3. **Install JS dependencies**
   npm install && npm run dev

4. **Copy and configure .env file**
   cp .env

5. **Edit .env**
    APP_NAME=pdfthisthat
    APP_ENV=local
    APP_KEY=
    APP_URL=

    DB_CONNECTION=mysql
    DB_HOST=
    DB_PORT=3306
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=

6. **Generate application key**
   php artisan key:generate

7. **Run migrations**
   php artisan migrate

8. **Start Apache and MySQL from XAMPP Control Panel**

9. **Access in browser**
   access in browser using APP_URL
   
