<?php
session_start();
require_once('db_connect.php');

$bookId = $_GET['book_id'];

if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    $userId = $user['id'];

    $rentalQuery = "UPDATE rentals SET status = 'Returned' WHERE user_id = '$userId' AND book_id = '$bookId' AND return_date > NOW()";
    $rentalResult = $conn->query($rentalQuery);
    if ($rentalResult) {
        $updateBookQuery = "UPDATE books SET qty_available = qty_available + 1 WHERE id = '$bookId'";
        $updateBookResult = $conn->query($updateBookQuery);
        if ($updateBookResult) {
            if ($book['qty_available'] + 1 == $book['qty']) {
                $updateBookStatusQuery = "UPDATE books SET status = 'Available' WHERE id = '$bookId'";
                $conn->query($updateBookStatusQuery);
            }
            header('Location: ../app/user_dashboard.php?success=Return_successful');
            exit;
        }
    }
} else {
    header('Location: ../app/login.php');
    exit;
}

