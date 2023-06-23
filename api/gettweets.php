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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $stmt = $pdo->prepare("SELECT * FROM tweets");
    $stmt->execute();

    $tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response = [
        'status' => 'success',
        'tweets' => $tweets
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
