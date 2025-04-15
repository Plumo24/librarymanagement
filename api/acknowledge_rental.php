<?php
session_start();
require_once('db_connect.php');

$rentalId = $_GET['rental_id'];
if (empty($rentalId)) {
    header('Location: ../app/manage_borrowed_books.php?error=Rental_id_not_provided');
    exit;
}

$rentalQuery = "SELECT * FROM rentals WHERE id = '$rentalId'";
$rentalResult = $conn->query($rentalQuery);
if ($rentalResult->num_rows > 0) {
    $updateRentalQuery = "UPDATE rentals SET date_out = NOW(), issuance_status = 'Approved' WHERE id = '$rentalId'";
    $updateRentalResult = $conn->query($updateRentalQuery);
    if ($updateRentalResult) {
        header('Location: ../app/manage_borrowed_books.php?success=rental_acknowledged');
        exit;
    } else {
        header('Location: ../app/manage_borrowed_books.php?error=rental_acknowledged_failed');
        exit;
    }
} else {
    header('Location: ../app/manage_borrowed_books.php?error=Rental_not_found');
    exit;
}

$conn->close();
