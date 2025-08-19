<?php
require_once __DIR__ . '/../models/ReservationModel.php';
require_once __DIR__ . '/../models/BookModel.php';

class ReservationController
{
    private $reservationModel;
    private $bookModel;

    public function __construct()
    {
        $this->reservationModel = new reservationModel();
        $this->bookModel = new BookModel();
    }

    public function index()
    {
        $user_id = $_SESSION['user_id'];

        if (empty($user_id)) {
            header('Location: index.php?route=user/login');
        }

        $result = $this->reservationModel->index($user_id);

        if ($result['success']) {
            $reservations = array();

            foreach ($result['result'] as $reservation) {
                $reservations[] = $this->bookModel->show($reservation['book_id'])['result'];
            }

            require __DIR__ . '/../views/reservations/index.php';
        } else {
            $error = $result['message'];
            require __DIR__ . '/../views/reservations/index.php';
        }
    }

    public function create()
    {
        if (!verifyCsrfToken($_POST['csrf_token'])) {
            die("Xato: CSRF token mos emas!");
        }

        $user_id = $_SESSION['user_id'];
        $book_id = htmlspecialchars($_POST['book_id'], ENT_QUOTES, 'UTF-8');

        $reservations = $this->reservationModel->index($user_id)['result'];

        if (!empty($reservations)) {
            foreach ($reservations as $reservation) {
                if (in_array($book_id, $reservation)) {
                    header('Location: index.php?route=reservation/index');
                    exit;
                }
            }
        }

        if (empty($user_id)) {
            header('Location: index.php?route=user/login');
        }

        if (empty($book_id)) {
            $error = 'Book id bo\'lishi kerak';
            require __DIR__ . '/../views/reservations/create.php';
        }

        $result = $this->reservationModel->create($user_id, $book_id);

        if ($result['success']) {
            header('Location: index.php?route=reservation/index');
            exit;
        } else {
            $error = $result['message'];
            require __DIR__ . '/../views/reservations/index.php';
        }
    }

}