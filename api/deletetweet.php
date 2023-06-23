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

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    $requestBody = json_decode(file_get_contents('php://input'), true);

    $username = $requestBody['username'];
    $tweetId = $requestBody['tweet_id'];

    $stmt = $pdo->prepare("SELECT * FROM tweets WHERE id = :id AND username = :username");
    $stmt->bindParam(':id', $tweetId);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $tweet = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($tweet) {
        $deleteStmt = $pdo->prepare("DELETE FROM tweets WHERE id = :id");
        $deleteStmt->bindParam(':id', $tweetId);
        $deleteStmt->execute();

        $response = [
            'status' => 'success',
            'message' => 'Tweet deleted successfully'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        
        $response = [
            'status' => 'error',
            'message' => 'You are not authorized to delete this tweet'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
?>
