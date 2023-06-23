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
    $tweetContent = $requestBody['content'];

    $createStmt = $pdo->prepare("INSERT INTO tweets (username, content) VALUES (:username, :content)");
    $createStmt->bindParam(':username', $username);
    $createStmt->bindParam(':content', $tweetContent);
    $createStmt->execute();

    $response = [
        'status' => 'success',
        'message' => 'Tweet created successfully'
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
