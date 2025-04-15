<?php
session_start();
include_once "db_connect.php";

if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['fullname']) || !isset($_POST['email'])) {
    header('Location: ../app/add_users.php?error=missing_inputs');
    exit;
}

$username = $_POST['username'];
$password = md5($_POST['password']);
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$phone = $_POST['phone'] ?? null;
$photo = $_FILES['photo'] ?? null;
$role = $_POST['role'] ?? 'user'; // Default to 'user' if not provided
$status = $_POST['status'] ?? 'in_review'; // Default to 'in_review' if not provided

$sql = "SELECT * FROM users WHERE id=$_POST[user_id]";
$execQuery = $conn->query($sql);
$user = $execQuery->fetch_assoc();

if ($photo != null && !empty($photo['tmp_name'])) {
    $newPhoto = uniqid() . '.' . pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    if (!is_dir('uploads')) mkdir('uploads', 0777, true); // Create the uploads directory if it doesn't exist
    if (!move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/' . $newPhoto)) {
        header('Location: ../app/add_users.php?error=photo_upload_failed');
        exit; 
    }
    unlink('uploads/' . $user['photo']);
    $photo = $newPhoto;
} else {
    $photo = $user['photo'];
}

$sql = "UPDATE users SET fullname='$fullname', email='$email', phone='$phone', username='$username', password='$password', photo='$photo', role='$role', status='$status' WHERE id=$_POST[user_id]";
$execQuery = $conn->query($sql);
if ($execQuery) {
    header('Location: ../app/manage_user.php?success=update_successful');
    exit;
}
