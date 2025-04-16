<?php
session_start();
include_once "db_connect.php";

if (!isset($_POST['title']) || !isset($_POST['author']) || !isset($_POST['isbn']) || !isset($_POST['genre'])) {
    header('Location: ../app/add_books.php?error=missing_inputs');
    exit;
}

$title = $_POST['title'];
$author =($_POST['author']);
$isbn = $_POST['isbn'];
$genre = $_POST['genre'];
$publisher = $_POST['publisher'];  
$published_date = $_POST['published_date'];
$status = $_POST['status'] ?? 'Available'; // Default to 'Available' if not provided
$qty_available = $_POST['qyt_available']; 
$total_qty = $_POST['total_qty'];
$photo = $_FILES['cover_photo'] ?? null;

$sql = "SELECT * FROM books WHERE id=$_POST[book_id]";
$execQuery = $conn->query($sql);
$book = $execQuery->fetch_assoc();
$book_id = $book['id'];


if ($photo != null && !empty($photo['tmp_name'])) {
    $newPhoto = uniqid() . '.' . pathinfo($_FILES['cover_photo']['name'], PATHINFO_EXTENSION);
    if (!is_dir('uploads')) mkdir('uploads', 0777, true); // Create the uploads directory if it doesn't exist
    if (!move_uploaded_file($_FILES['cover_photo']['tmp_name'], 'uploads/' . $newPhoto)) {
        header('Location: ../app/add_books.php?error=photo_upload_failed');
        exit; 
    }
    unlink('uploads/' . $book['cover_photo']);
    $photo = $newPhoto;
} else {
    $photo = $book['cover_photo'];
}

$sql = "UPDATE books SET title='$title', author='$author', isbn='$isbn', genre='$genre', publisher='$publisher', published_date='$published_date', status='$status', qty_available='$qty_available', total_qty='$total_qty' WHERE id = $book_id";
$execQuery = $conn->query($sql);
if ($execQuery) {
    header('Location: ../app/manage_books.php?success=update_successful');
    exit;
} else {
    // header('Location: ../app/manage_books.php?error=update_failed');
    echo json_encode(['status' => 'error', 'message' => 'Failed to update book']);
    exit;
}
