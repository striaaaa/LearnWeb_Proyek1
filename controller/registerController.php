<?php
require_once __DIR__ . '/../helpers/url.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/db_helper.php';
require_once __DIR__ . '/../components/alert.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$baseFolder = basefolder();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $errors = [];

    if ($name === '') {
        $errors[] = 'Nama tidak boleh kosong.';
    }

    if ($email === '') {
        $errors[] = 'Email tidak boleh kosong.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid.';
    }

    if ($password === '') {
        $errors[] = 'Password tidak boleh kosong.';
    } elseif (strlen($password) < 8) {
        $errors[] = 'Password minimal 8 karakter.';
    }


    if (!empty($errors)) {
        setFlashAlert('error', $errors[0]);
        header("Location: " . $baseFolder . "/register");
        exit;
    }

    try {
       
        $checkEmail = runQuery("SELECT user_id FROM users WHERE email = ?", [$email]);
        if (!empty($checkEmail->user_id)) {
            setFlashAlert('warning', 'Email sudah terdaftar. Silakan login.');
            header("Location: " . $baseFolder . "/login");
            exit;
        }
 
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
        $roleUser = 'user';
 
        $insert = runQuery(
            "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)",
            [$name, $email, $hashedPassword, $roleUser]
        );

        if ($insert['affected_rows'] > 0) {
            $userId = $insert['insert_id'];
            $token = bin2hex(random_bytes(32));
 
            runQuery("UPDATE users SET login_token = ? WHERE user_id = ?", [$token, $userId]);
 
            setcookie(
                "login_token",
                $token,
                time() + (30 * 24 * 60 * 60), 
                "/",
                "",
                false,
                true
            );

            $_SESSION['login_token'] = $token;

            setFlashAlert('success', 'Registrasi berhasil! Selamat datang, ' . htmlspecialchars($name) . '!');
            header("Location: " . $baseFolder . "/");
            exit;
        } else {
            setFlashAlert('error', 'Registrasi gagal. Silakan coba lagi.');
            header("Location: " . $baseFolder . "/register");
            exit;
        }

    } catch (Exception $e) {
        setFlashAlert('error', 'Terjadi kesalahan: ' . htmlspecialchars($e->getMessage()));
        header("Location: " . $baseFolder . "/register");
        exit;
    }
}
