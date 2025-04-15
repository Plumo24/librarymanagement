<?php
session_start();
require_once('db_connect.php');

$bookId = $_GET['book_id'];

if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    $userId = $user['id'];

    $borrowQuery = "SELECT * FROM rentals WHERE user_id = '$userId' AND book_id = '$bookId'";
    $borrowResult = $conn->query($borrowQuery);
    if ($borrowResult->num_rows > 0) {
        header('Location: ../app/user_dashboard.php?error=Book_already_borrowed');
        exit;
    }

    $bookQuery = "SELECT * FROM books WHERE id = '$bookId'";
    $bookResult = $conn->query($bookQuery);
    $book = $bookResult->fetch_assoc();
    if ($book['status'] == 'Unavailable') {
        header('Location: ../app/user_dashboard.php?error=Book_unavailable');
        exit;
    }

    $rentalQuery = "INSERT INTO rentals (user_id, book_id, return_date) VALUES ('$userId', '$bookId', NOW() + INTERVAL 7 DAY)";
    $rentalResult = $conn->query($rentalQuery);
    if ($rentalResult) {
        $updateBookQuery = "UPDATE books SET qty_available = qty_available - 1 WHERE id = '$bookId'";
        $updateBookResult = $conn->query($updateBookQuery);
        if ($updateBookResult) {
            if ($book['qty_available'] - 1 == 0) {
                $updateBookStatusQuery = "UPDATE books SET status = 'Unavailable' WHERE id = '$bookId'";
                $conn->query($updateBookStatusQuery);
            }
            header('Location: ../app/user_dashboard.php?success=Borrow_successful');
            exit;
        }
    }
} else {
    header('Location: ../app/login.php');
    exit;
}
