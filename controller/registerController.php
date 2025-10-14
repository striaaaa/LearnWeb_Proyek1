<?php
require_once __DIR__ . '/../helpers/url.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/db_helper.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
 
    if ($name === '' || $email === '' || $password === '') {
        echo "Semua field wajib diisi.";
        exit;
    }

    try { 
        $checkEmail = runQuery(
            "SELECT user_id FROM users WHERE email = ?",
            [$email]
        );

        if (!empty($checkEmail)) {
            echo "Email sudah terdaftar. Silakan login.";
            exit;
        }
 
        $options = ['cost' => 12];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT, $options);
        $roleUser = 'user';
 
        $insert = runQuery(
            "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)",
            [$name, $email, $hashedPassword, $roleUser]
        );

        if ($insert['affected_rows'] > 0) {

            $userId = $insert['insert_id'];
 
            $token = bin2hex(random_bytes(32));
            runQuery(
                "UPDATE users SET login_token = ? WHERE user_id = ?",
                [$token, $userId]
            );
 
            setcookie(
                "login_token",
                $token,
                time() + (30 * 24 * 60 * 60), // 30 hari
                "/",
                "",
                false,
                true
            );

            $_SESSION['login_token'] = $token;
 
            header('Location: ' . basefolder() . '/');
            exit;
        } else {
            echo "Registrasi gagal. Coba lagi.";
        }

    } catch (Exception $e) {
        echo "Terjadi kesalahan: " . htmlspecialchars($e->getMessage());
    }
}
