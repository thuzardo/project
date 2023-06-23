<?php

include "config.php";

$dsn = "mysql:host=localhost;dbname=kodego_db";
$username = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $requestBody = json_decode(file_get_contents('php://input'), true);

    $username = $requestBody['username'];
    $newProfileData = $requestBody['profile'];

    $encodedProfile = json_encode($newProfileData);

    $updateStmt = $pdo->prepare("UPDATE users SET profile = :profile WHERE username = :username");
    $updateStmt->bindParam(':profile', $encodedProfile);
    $updateStmt->bindParam(':username', $username);
    $updateStmt->execute();

    $response = [
        'status' => 'success',
        'message' => 'Profile updated successfully'
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
