# Library

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
│   │   ├── create.php
│   ├── layouts/
│   │   ├── header.php
│   │   ├── footer.php
├── config/
│   ├── database.php
├── index.php
├── .htaccess

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
loyiha boshiga shu kod qo'yilsa hatolar chiqadi server qulaganda