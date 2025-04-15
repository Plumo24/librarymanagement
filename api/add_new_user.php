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

$sql = "SELECT * FROM users WHERE email='$email' OR (username='$username' AND password='$password')";
$execQuery = $conn->query($sql);

if ($execQuery->num_rows > 0) {
    header('Location: ../app/add_users.php?error=user_exists');
    exit;
}

if (!empty($photo['tmp_name']) && $photo != null) {
    $photo = uniqid() . '.' . pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    if (!is_dir('uploads')) mkdir('uploads', 0777, true); // Create the uploads directory if it doesn't exist
    if (!move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/' . $photo)) {
        header('Location: ../app/add_users.php?error=photo_upload_failed');
        exit; 
    }
}else {
    $photo = 'default.webp'; // Use a default photo if none is uploaded
}

$sql = "INSERT INTO users(fullname, email, phone, username, password, photo, role, status) VALUES('$fullname', '$email', '$phone','$username','$password','$photo','$role','$status')";
$execQuery = $conn->query($sql);
if ($execQuery) {
    header('Location: ../app/manage_user.php?success=registration_successful');
    exit;
}