<?php
session_start();
include_once "db_connect.php";

if (!isset($_GET['book_id'])) {
    header('Location: ../app/manage_book.php?error=user_not_found');
    exit;
}

$bookId = $_GET['book_id'];
// Delete the book records from rentals table
$rentalQuery = "DELETE FROM rentals WHERE book_id = $bookId";
$rentalResult = $conn->query($rentalQuery);

// Delete the book record
$userQuery = "DELETE FROM books WHERE id = $bookId";
$userResult = $conn->query($userQuery);

header('Location: ../app/manage_books.php?success=delete_successfull');