<?php
session_start();
require_once('db_connect.php');

$rentalId = $_GET['rental_id'];


$rentalQuery = "UPDATE rentals SET issuance_status = 'Returned' WHERE id = '$rentalId' AND issuance_status = 'Approved'";
$rentalResult = $conn->query($rentalQuery);
if ($rentalResult) {
    // Update the book status to available
    $rentalQuery2 = "UPDATE books SET status = 'Available', qty_available = qty_available + 1 WHERE id = (SELECT book_id FROM rentals WHERE id = '$rentalId')";
    $rentalResult2 = $conn->query($rentalQuery2);
    header('Location: ../app/manage_borrowed_books.php?success=Rental_returned');
    exit;
}
else {
    header('Location: ../app/manage_borrowed_books.php?error=Rental_return_failed');
    exit;
}
$conn->close();
