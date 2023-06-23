<?php

include "config.php";

$dsn = "mysql:localhost;dbname=kodego_db";
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
    $currentPassword = $requestBody['current_password'];
    $newPassword = $requestBody['new_password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($currentPassword, $user['password'])) {
        
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $updateStmt = $pdo->prepare("UPDATE users SET password = :password WHERE username = :username");
        $updateStmt->bindParam(':password', $hashedPassword);
        $updateStmt->bindParam(':username', $username);
        $updateStmt->execute();

        $response = [
            'status' => 'success',
            'message' => 'Password updated successfully'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        
        $response = [
            'status' => 'error',
            'message' => 'Incorrect current password'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
?>
