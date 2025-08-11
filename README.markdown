ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
loyiha boshiga shu kod qo'yilsa hatolar chiqadi server qulaganda

# Online Kutubxona Tizimi

Bu loyiha PHP MVC arxitekturasini mustahkamlash uchun yaratilgan bo‘lib, keyinchalik Laravel framework’iga o‘tishni rejalashtirayotgan dasturchilar uchun moslashtirilgan. Loyiha online kutubxona tizimini amalga oshiradi, unda foydalanuvchilar kitoblar ro‘yxatini ko‘rish, qidirish va bron qilish imkoniyatiga ega, adminlar esa kitoblar va kategoriyalarni boshqaradi.

## Loyiha haqida

- **Maqsad**: PHP MVC arxitekturasini chuqur o‘rganish va mustahkamlash, ko‘p jadvalli munosabatlar, autentifikatsiya va rolga asoslangan boshqaruvni amalga oshirish.
- **Texnologiyalar**:
  - **Backend**: PHP (MVC, framework’siz)
  - **Ma’lumotlar bazasi**: MariaDB
  - **Frontend**: Bootstrap 5
  - **Server**: Apache (Nobara Linux muhitida sinovdan o‘tkazilgan)
- **Funksiyalar**:
  - Foydalanuvchi ro‘yxatdan o‘tishi, kirishi va chiqishi.
  - Kitoblar ro‘yxatini ko‘rish, qidirish va tafsilotlarini ko‘rish.
  - Adminlar uchun kitob va kategoriyalarni qo‘shish, tahrirlash, o‘chirish.
  - Foydalanuvchilar uchun kitob bron qilish.

## O‘rnatish

### 1. Mu hitni sozlash

Nobara Linux muhitida Apache, PHP va MariaDB o‘rnatilgan deb hisoblanadi. Quyidagi qadamlar loyiha jildini sozlash uchun:

```bash
# Apache va MariaDB xizmatlarini tekshirish
sudo systemctl status httpd
sudo systemctl status mariadb

# Agar ishlamasa, xizmatlarni ishga tushirish
sudo systemctl start httpd mariadb
sudo systemctl enable httpd mariadb

# PHP sozlamalari (xatolarni ko‘rsatish uchun)
sudo nano /etc/php.ini
```

`/etc/php.ini` faylida quyidagi qatorlarni sozlang:

```
display_errors = On
display_startup_errors = On
error_reporting = E_ALL
```

Apache’ni qayta ishga tushirish:

```bash
sudo systemctl restart httpd
```

Loyiha jildini yaratish:

```bash
sudo mkdir /var/www/html/library
sudo chown -R apache:apache /var/www/html/library
sudo chmod -R 755 /var/www/html/library
```

### 2. Ma’lumotlar bazasini sozlash

MariaDB’da `library` ma’lumotlar bazasi va jadvallarni yaratish:

```bash
mysql -u root -p
```

SQL buyruqlari:

```sql
CREATE DATABASE library CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE library;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    author VARCHAR(100),
    category_id INT,
    description TEXT,
    available BOOLEAN DEFAULT TRUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    book_id INT,
    status ENUM('pending', 'approved', 'returned') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
);
```

Namunaviy ma’lumotlar:

```sql
INSERT INTO users (username, email, password, role) VALUES
('testuser', 'test@example.com', '$2y$10$YOUR_HASHED_PASSWORD', 'user'),
('admin', 'admin@example.com', '$2y$10$YOUR_HASHED_PASSWORD', 'admin');

INSERT INTO categories (name) VALUES
('Fantastika'),
('Ilmiy'),
('Roman');

INSERT INTO books (title, author, category_id, description, available) VALUES
('Dune', 'Frank Herbert', 1, 'Fantastik roman', TRUE),
('Sapiens', 'Yuval Noah Harari', 2, 'Insoniyat tarixi', TRUE),
('Pride and Prejudice', 'Jane Austen', 3, 'Klassik romantik roman', TRUE);
```

Parol xeshini olish:

```bash
php -a
echo password_hash('parol123', PASSWORD_BCRYPT);
```

### 3. Apache sozlamalari

`mod_rewrite` yoqish:

```bash
sudo a2enmod rewrite
```

Apache konfiguratsiyasini sozlash:

```bash
sudo nano /etc/httpd/conf/httpd.conf
```

`<Directory "/var/www/html">` bo‘limida:

```
<Directory "/var/www/html">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

Apache’ni qayta ishga tushirish:

```bash
sudo systemctl restart httpd
```

### 4. Loyiha fayllarini joylashtirish

Loyiha fayllarini `/var/www/html/library` jildiga joylashtiring. Loyiha tuzilmasi:

```
library/
├── controllers/
│   ├── UserController.php
│   ├── BookController.php
│   ├── CategoryController.php
│   ├── ReservationController.php
├── models/
│   ├── User.php
│   ├── Book.php
│   ├── Category.php
│   ├── Reservation.php
├── views/
│   ├── users/
│   │   ├── login.php
│   │   ├── register.php
│   ├── books/
│   │   ├── index.php
│   │   ├── show.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   ├── search.php
│   ├── categories/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   ├── reservations/
│   │   ├── index.php
│   ├── layouts/
│   │   ├── header.php
│   │   ├── footer.php
├── config/
│   ├── database.php
├── index.php
├── .htaccess
```

Ruxsatlarni sozlash:

```bash
sudo chown -R apache:apache /var/www/html/library
sudo chmod -R 755 /var/www/html/library
```

## URL’lar ro‘yxati

Quyida loyihadagi barcha URL’lar, ularning maqsadi, controller/action va foydalanuvchi rollari keltirilgan.

### Foydalanuvchi bilan bog‘liq URL’lar

| URL              | Maqsad            | Controller/Action          | Foydalanuvchi turi | Tavsif                                                                                  |
| ---------------- | ----------------- | -------------------------- | ------------------ | --------------------------------------------------------------------------------------- |
| `/user/register` | Ro‘yxatdan o‘tish | `UserController::register` | Har kim            | Yangi foydalanuvchi hisobini yaratadi (GET: forma, POST: saqlash).                      |
| `/user/login`    | Kirish            | `UserController::login`    | Har kim            | Foydalanuvchi email va parol bilan tizimga kiradi (GET: forma, POST: autentifikatsiya). |
| `/user/logout`   | Chiqish           | `UserController::logout`   | Tizimga kirganlar  | Sessiyani yo‘q qiladi va login sahifasiga yo‘naltiradi.                                 |

### Kitoblar bilan bog‘liq URL’lar

| URL                         | Maqsad             | Controller/Action        | Foydalanuvchi turi | Tavsif                                                                                                               |
| --------------------------- | ------------------ | ------------------------ | ------------------ | -------------------------------------------------------------------------------------------------------------------- |
| `/book/index`               | Kitoblar ro‘yxati  | `BookController::index`  | Har kim            | Mavjud kitoblar ro‘yxatini ko‘rsatadi. Qidiruv formasi mavjud.                                                       |
| `/book/show&id=<id>`        | Kitob tafsilotlari | `BookController::show`   | Har kim            | Kitobning tafsilotlarini ko‘rsatadi. Tizimga kirganlar bron qilishi mumkin, adminlar tahrirlash/o‘chirishni ko‘radi. |
| `/book/create`              | Kitob qo‘shish     | `BookController::create` | Admin              | Admin yangi kitob qo‘shadi (GET: forma, POST: saqlash).                                                              |
| `/book/edit&id=<id>`        | Kitobni tahrirlash | `BookController::edit`   | Admin              | Admin kitob ma’lumotlarini tahrirlaydi (GET: forma, POST: yangilash).                                                |
| `/book/delete&id=<id>`      | Kitobni o‘chirish  | `BookController::delete` | Admin              | Admin kitobni o‘chiradi (tasdiqlash oynasi bilan).                                                                   |
| `/book/search&query=<so‘z>` | Kitob qidirish     | `BookController::search` | Har kim            | Kitob sarlavhasi yoki muallifi bo‘yicha qidiruv natijalarini ko‘rsatadi.                                             |

### Kategoriyalar bilan bog‘liq URL’lar

| URL                        | Maqsad                  | Controller/Action            | Foydalanuvchi turi | Tavsif                                                             |
| -------------------------- | ----------------------- | ---------------------------- | ------------------ | ------------------------------------------------------------------ |
| `/category/index`          | Kategoriyalar ro‘yxati  | `CategoryController::index`  | Admin              | Barcha kategoriyalarni ro‘yxat sifatida ko‘rsatadi.                |
| `/category/create`         | Kategoriya qo‘shish     | `CategoryController::create` | Admin              | Admin yangi kategoriya qo‘shadi (GET: forma, POST: saqlash).       |
| `/category/edit&id=<id>`   | Kategoriyani tahrirlash | `CategoryController::edit`   | Admin              | Admin kategoriya nomini tahrirlaydi (GET: forma, POST: yangilash). |
| `/category/delete&id=<id>` | Kategoriyani o‘chirish  | `CategoryController::delete` | Admin              | Admin kategoriyani o‘chiradi (tasdiqlash oynasi bilan).            |

### Bronlar bilan bog‘liq URL’lar

| URL                                | Maqsad              | Controller/Action               | Foydalanuvchi turi | Tavsif                                                                      |
| ---------------------------------- | ------------------- | ------------------------------- | ------------------ | --------------------------------------------------------------------------- |
| `/reservation/index`               | Bronlar ro‘yxati    | `ReservationController::index`  | Tizimga kirganlar  | Foydalanuvchining bronlarini (kitob, muallif, holat, sana) ko‘rsatadi.      |
| `/reservation/create&book_id=<id>` | Kitobni bron qilish | `ReservationController::create` | Tizimga kirganlar  | Foydalanuvchi kitobni bron qiladi, kitobning mavjudligi FALSE ga o‘zgaradi. |

## Test qilish

1. **Ma’lumotlar bazasini tekshirish**:

   ```sql
   USE library;
   SHOW TABLES;
   ```

2. **Namuna sinovlar**:

   - **Admin**: `email: admin@example.com`, `password: parol123`
     - `/category/index` → Kategoriyalarni ko‘rish.
     - `/book/create` → Yangi kitob qo‘shish.
   - **Oddiy foydalanuvchi**: `email: test@example.com`, `password: parol123`
     - `/book/index` → Kitoblar ro‘yxati.
     - `/reservation/create&book_id=1` → Kitobni bron qilish.
   - **Qidiruv**: `/book/search&query=Sapiens` → “Sapiens” kitobini qidirish.

3. **Xatolarni tekshirish**:
   - Loglarni ko‘rish:
     ```bash
     sudo tail -f /var/log/httpd/error_log
     ```
   - `index.php` da `var_dump($_GET['route'])` ni sinash:
     ```php
     var_dump($_GET['route']);
     die("Test");
     ```

## Xavfsizlik

- **CSRF himoyasi** (tavsiya):
  Formaga token qo‘shish:

  ```php
  session_start();
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  ?>
  <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
  ```

  Controller’da tekshirish:

  ```php
  if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
      die("CSRF token xatosi!");
  }
  ```

- **SQL injection**: PDO prepared statements ishlatilgan.
- **XSS**: `htmlspecialchars()` barcha chiqishlarda qo‘llanilgan.

## Qo‘shimcha maslahatlar

1. **Pagination qo‘shish**:
   Kitoblar ro‘yxati uchun:

   ```php
   $page = $_GET['page'] ?? 1;
   $limit = 10;
   $offset = ($page - 1) * $limit;
   $stmt = $this->pdo->prepare("SELECT books.*, categories.name AS category_name
                                FROM books
                                JOIN categories ON books.category_id = categories.id
                                LIMIT ? OFFSET ?");
   $stmt->execute([$limit, $offset]);
   ```

2. **GitHub’ga yuklash**:

   ```bash
   cd /var/www/html/library
   git init
   git add .
   git commit -m "Online kutubxona loyihasi"
   git remote add origin https://github.com/sizning-username/php-library.git
   git push -u origin main
   ```

3. **Laravel’ga tayyorgarlik**:
   - Model munosabatlari (`hasMany`, `belongsTo`) va rol tekshiruvi Laravel’ning Eloquent ORM va middleware’lariga o‘xshaydi.
   - Laravel’ni o‘rnatish:
     ```bash
     composer create-project laravel/laravel library-laravel
     ```
   - Dokumentatsiya: [Laravel Docs](https://laravel.com/docs)

## Muammolar bo‘lsa

- **URL ishlamasa**:

  - `.htaccess` faylini tekshiring.
  - `mod_rewrite` yoqilganligiga ishonch hosil qiling:
    ```bash
    sudo a2enmod rewrite
    sudo systemctl restart httpd
    ```

- **Ma’lumotlar bazasi xatosi**:

  - `config/database.php` da sozlamalarni tekshiring (host, username, password).

- **Loglar**:
  ```bash
  sudo tail -f /var/log/httpd/error_log
  ```

Loyihada qo‘shimcha funksiyalar (masalan, AJAX qidiruv yoki rasm yuklash) yoki onlayn serverga joylashtirish bo‘yicha yordam kerak bo‘lsa, murojaat qiling!
