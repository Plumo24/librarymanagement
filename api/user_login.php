<?php
session_start();
include_once "db_connect.php";

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    header('Location: ../app/login.php?error=invalid_credentials');
    exit;
}

$username = $_POST['username'];
$password = md5($_POST['password']);
$role = $_POST['role'] ?? '';

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$execQuery = $conn->query($sql);

if ($execQuery->num_rows > 0) {
    $user = $execQuery->fetch_assoc();
    if ($role !== $user['role']) {
        header('Location: ../app/login.php?error=role_missmatch');
        exit;
    } 

    $_SESSION['user'] = serialize($user);
    $_SESSION['user_id'] = $user['id'];

    if ($role == 'admin') {
        header('Location: ../app/admin.php');
    } else {
        header('Location: ../app/user_dashboard.php');
    }
}else{
    header('Location: ../app/login.php?error=invalid_credentials');
    exit;
}