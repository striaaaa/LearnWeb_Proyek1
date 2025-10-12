<?php
require_once __DIR__ . '/../helpers/url.php';
require_once __DIR__ . '/../config/database.php';
$mysqli = getMysqliConnection();

$baseFolder = basefolder();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $token = bin2hex(random_bytes(32));

    // 1. Ambil user berdasarkan email (prepared statement)
    $stmt = $mysqli->prepare("SELECT user_id, name, password, role FROM users WHERE email = ?");
    if (!$stmt) {
        die("Prepare gagal: " . $mysqli->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $storedHash = $user['password']; // hash yang tersimpan di DB
        $updateLoginToken= $mysqli->prepare("UPDATE users SET login_token = ? WHERE user_id = ?");
        $updateLoginToken->bind_param("si", $token, $user['user_id']);
        $updateLoginToken->execute();

        // 2. Verifikasi password
        if (password_verify($password, $storedHash)) {
            $newOptions = ['cost' => 12];
            if (password_needs_rehash($storedHash, PASSWORD_DEFAULT, $newOptions)) {
                $newHash = password_hash($password, PASSWORD_DEFAULT, $newOptions);
                $updateHashStmt = $mysqli->prepare("UPDATE users SET password = ? WHERE user_id = ?");
                var_dump($updateHashStmt);
                die();
                if (!$updateHashStmt) {
                    die("Prepare failed: " . $mysqli->error);
                }
                $updateHashStmt->bind_param("si", $newHash, $user['user_id']); 
                if ($updateHashStmt->execute()) {
                    echo "Password dan token berhasil diupdate.";
                } else {
                    echo "Gagal update: " . $updateHashStmt->error;
                }

                $updateHashStmt->close();
            }
            // $_SESSION['login_token'] = $user['login_token'];
            setcookie(
                "login_token",
                $token,
                time() + (30 * 24 * 60 * 60),
                "/",
                "",
                false,
                true
            );
            if ($user['role'] === 'admin') {
                header('Location:' . basefolder() . '/admin/dashboard');
            } else {
                // header('Location:' . basefolder() . '/');
            }
            echo "Login berhasil. Selamat datang, " . htmlspecialchars($user['name']);
        } else {
            echo "Email atau password salah.";
        }
    } else {
        echo "Email atau password salah.";
    }
    $stmt->close();
}

$mysqli->close();
session_start();
$baseFolder = basefolder();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    $mysqli = getMysqliConnection();
    $stmt = $mysqli->prepare("UPDATE users SET login_token = NULL WHERE login_token = ?");
    $stmt->bind_param("s", $_SESSION['login_token']);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
    $_SESSION = [];
    session_destroy();
    setcookie("login_token", "", time() - 3600, "/", "", false, true);
    header('Location:' . $baseFolder . '/');
    exit;
}
