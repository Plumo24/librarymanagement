<?php
session_start();
require_once('db_connect.php');

$bookId = $_GET['book_id'];

if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    $userId = $user['id'];

    $rentalQuery = "SELECT * FROM rentals WHERE user_id = '$userId' AND book_id = '$bookId' AND issuance_status != 'Approved'";
    $rentalResult = $conn->query($rentalQuery);

    if ($rentalResult->num_rows > 0) {
        $deleteRentalQuery = "DELETE FROM rentals WHERE user_id = '$userId' AND book_id = '$bookId' AND issuance_status != 'Approved'";
        if ($conn->query($deleteRentalQuery)) {
            $updateBookQuery = "UPDATE books SET qty_available = qty_available + 1 WHERE id = '$bookId'";
            $conn->query($updateBookQuery);

            header('Location: ../app/borrowed_books.php?success=request_cancelled');
            exit;
        }
    } else {
        header('Location: ../app/borrowed_books.php?error=cancel_failed');
        exit;
    }
} else {
    header('Location: ../app/login.php');
    exit;
}

