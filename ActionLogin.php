<?php
session_start();
include 'ConnectDatabase.php';

header('Content-Type: application/json');

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    echo json_encode([
        "success" => false,
        "message" => "Permintaan harus melalui AJAX."
    ]);
    exit;
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if ($password === $user['password']) {
        $_SESSION['username'] = $username;
        echo json_encode([
            "success" => true,
            "message" => "Login berhasil"
        ]);
        exit;
    }
}

echo json_encode([
    "success" => false,
    "message" => "Login gagal. Username atau password salah."
]);
?>