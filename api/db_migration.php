<?php

    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bookstore";

    $conn = new mysqli($hostname, $username, $password);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DROP DATABASE IF EXISTS " . $dbname;
    if ($conn->query($sql) === TRUE) {
        echo "Database deleted successfully <br>";
    } else {
        echo "Error creating database: " . $conn->error;
    }

    $sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully <br>";
    } else {
        echo "Error creating database: " . $conn->error;
    }

    // Connect database to connection
    $conn->select_db($dbname);


    // Create tables Users
    $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            fullname VARCHAR(30) NOT NULL,
            email VARCHAR(30) NOT NULL,
            phone VARCHAR(30) NOT NULL,
            username VARCHAR(30) NOT NULL,
            password VARCHAR(50) NOT NULL,
            status ENUM('active', 'inactive', 'in_review') NOT NULL DEFAULT 'in_review',
            role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
            photo VARCHAR(100) DEFAULT NULL
        );";

    if ($conn->query($sql) === TRUE) {
        echo "Table users created successfully <br>";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    // Create tables Books
    $sql = "CREATE TABLE IF NOT EXISTS books (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(50) NOT NULL,
            author VARCHAR(50) NOT NULL,
            isbn VARCHAR(20) NOT NULL,
            genre VARCHAR(20) NOT NULL,
            publisher VARCHAR(50) NOT NULL,
            published_date DATE NOT NULL,
            status ENUM('Available', 'Unavailable') NOT NULL,
            qty_available INT(6) NOT NULL,
            total_qty INT(6) NOT NULL,
            cover_photo VARCHAR(100) DEFAULT NULL
        );";
        
    if ($conn->query($sql) === TRUE) {
        echo "Table books created successfully <br>";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    // Create tables Rentals
    $sql = "CREATE TABLE IF NOT EXISTS rentals (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT(6) UNSIGNED NOT NULL,
            book_id INT(6) UNSIGNED NOT NULL,
            date_out DATE DEFAULT NULL,
            date_in DATE DEFAULT NULL,
            status ENUM('Borrowed', 'Returned', 'Cancelled') NOT NULL DEFAULT 'Borrowed',
            return_date DATE NOT NULL,
            issuance_status ENUM('Pending', 'Approved', 'Rejected', 'Returned') NOT NULL DEFAULT 'Pending',
            FOREIGN KEY (user_id) REFERENCES users(id),
            FOREIGN KEY (book_id) REFERENCES books(id)
        );";

    if ($conn->query($sql) === TRUE) {
        echo "Table rentals created successfully <br>";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    // Create default admin account with default password encrypted to md5
    $password = md5('admin');
    $sql = "INSERT INTO users (fullname, email, phone, username, password, role) VALUES ('Pelu Admin', 'manlikeplumo@icloud.com', '+44 70881154061', 'admin', '$password', 'admin');";

    if ($conn->query($sql) === TRUE) {
        echo "Default admin account created successfully <br>";
    } else {        
        echo "Error creating default admin account: " . $conn->error;
    }

    $conn->close();
