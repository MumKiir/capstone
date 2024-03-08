<?php
$mysqli = require __DIR__ . "/database.php";

if (isset($_GET["email"])) {
    $email = $_GET["email"];

    // Prepare SQL statement to check if email exists
    $query = "SELECT COUNT(*) AS count FROM user WHERE email = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $emailCount = $row['count'];

    // Return JSON response indicating email availability
    header("Content-Type: application/json");
    echo json_encode(["available" => $emailCount == 0]);
} else {
    // If email parameter is not provided, return an error
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(["error" => "Email parameter is missing"]);
}
?>
