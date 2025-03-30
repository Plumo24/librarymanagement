<?php

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

if ($role == 'admin') {
    header('Location: ../App/Admin.html');
} else {
    header('Location: ../App/userDashboard.html');
}