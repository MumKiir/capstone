<?php

if (empty($_POST["name"])) {
    die("Name is required");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

// Check if email already exists
$email = $_POST["email"];
$query = "SELECT COUNT(*) as count FROM user WHERE email = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$email_count = $row['count'];

if ($email_count > 0) {
    // Email already exists, return an error message
    die("Email already taken");
}

// Email does not exist, proceed with insertion
$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)){
    die("SQL error: ". $mysqli->error);
}

$stmt->bind_param("sss",
                  $_POST["name"],
                  $_POST["email"],
                  $password_hash);

if ($stmt->execute()) {
    header("location: signup-success.html");
    exit;
} else {
    // Output the MySQL error message
    die($mysqli->error);
}

