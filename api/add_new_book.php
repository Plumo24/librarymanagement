<?php
session_start();
include_once "db_connect.php";

if (!isset($_POST['title']) || !isset($_POST['author']) || !isset($_POST['isbn']) || !isset($_POST['genre'])) {
    header('Location: ../app/add_books.php?error=missing_inputs');
    exit;
}

$title = $_POST['title'];
$author =$_POST['author'];
$isbn = $_POST['isbn'];
$genre = $_POST['genre'];
$publisher = $_POST['publisher'];
$published_date = $_POST['published_date'];
// $status = $_POST['status'];
$qty_available = $_POST['qty_available'];
$total_qty = $_POST['total_qty'];
$photo = $_FILES['cover_photo'] ?? null;
 
$sql = "SELECT * FROM books WHERE title='$title' OR (author='$author' AND isbn='$isbn')";
$execQuery = $conn->query($sql);

if ($execQuery->num_rows > 0) {
    header('Location: ../app/add_books.php?error=user_exists');
    exit;
}

if (!empty($photo['tmp_name']) && $photo != null) {
    $photo = uniqid() . '.' . pathinfo($_FILES['cover_photo']['name'], PATHINFO_EXTENSION);
    if (!is_dir('uploads/books')) mkdir('uploads/books', 0777, true); // Create the uploads directory if it doesn't exist
    if (!move_uploaded_file($_FILES['cover_photo']['tmp_name'], 'uploads/books/' . $photo)) {
        header('Location: ../app/add_books.php?error=photo_upload_failed');
        exit; 
    }
}else {
    $photo = 'default.webp'; // Use a default photo if none is uploaded
}

$sql = "INSERT INTO books(title, author, isbn, genre, publisher, published_date, qty_available, total_qty, cover_photo) VALUES('$title', '$author', '$isbn', '$genre','$publisher','$published_date','$qty_available','$total_qty','$photo')";
$execQuery = $conn->query($sql);
if ($execQuery) {
    header('Location: ../app/manage_books.php?success=registration_successful');
    exit;
}