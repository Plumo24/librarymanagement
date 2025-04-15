<?php
session_start();
include_once "db_connect.php";

if (!isset($_GET['user_id'])) {
    header('Location: ../app/manage_user.php?error=user_not_found');
    exit;
}

$userId = $_GET['user_id'];
$userQuery = "DELETE FROM users WHERE id = $userId";
$userResult = $conn->query($userQuery);

header('Location: ../app/manage_user.php?success=delete_successfull');