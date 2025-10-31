<?php
require_once __DIR__ . '/../helpers/url.php';
require_once __DIR__ . '/../helpers/db_helper.php';
require_once __DIR__ . '/../components/alert.php';

$baseFolder = basefolder();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $token = bin2hex(random_bytes(32));
    $errors = [];

    
    if (empty($email)) {
        $errors[] = 'Email tidak boleh kosong.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid.';
    }

    if (empty($password)) {
        $errors[] = 'Password tidak boleh kosong.';
    } elseif (strlen($password) < 8) {
        $errors[] = 'Password minimal 8 karakter.';
    }
    

    if (!empty($errors)) {
        setFlashAlert('error', $errors[0]);  
        header("Location: " . $baseFolder . "/login");
        exit;
    }

    
    $userQuery = "SELECT user_id, name, password, role FROM users WHERE email = ?";
    $user = runQuery($userQuery, [$email]);

    if (!$user) {
        setFlashAlert('error', 'Email belum terdaftar.');
        header("Location: " . $baseFolder . "/login");
        exit;
    }

    
    if (!password_verify($password, $user->password ?? '')) {
        setFlashAlert('error', 'Password salah.');
        header("Location: " . $baseFolder . "/login");
        exit;
    }

    
    runQuery("UPDATE users SET login_token = ? WHERE user_id = ?", [$token, $user->user_id]);

    
    $newOptions = ['cost' => 12];
    if (password_needs_rehash($user->password, PASSWORD_DEFAULT, $newOptions)) {
        $newHash = password_hash($password, PASSWORD_DEFAULT, $newOptions);
        runQuery("UPDATE users SET password = ? WHERE user_id = ?", [$newHash, $user->user_id]);
    } 

    setcookie(
        "login_token",
        $token,
        time() + (30 * 24 * 60 * 60),
        "/",
        "",
        false,
        true
    );
 
    if ($user->role === 'admin') {
        setFlashAlert('success', 'Login berhasil. Selamat datang Admin!');
        header("Location: " . $baseFolder . "/admin/dashboard");
    } elseif ($user->role === 'user') {
        setFlashAlert('success', 'Selamat datang kembali!');
        header("Location: " . $baseFolder . "/");
    } else {
        setFlashAlert('warning', 'Peran pengguna tidak dikenali.');
        header("Location: " . $baseFolder . "/login");
    }

    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    if (isset($_COOKIE['login_token'])) {
        runQuery("UPDATE users SET login_token = NULL WHERE login_token = ?", [$_COOKIE['login_token']]);
        setcookie("login_token", "", time() - 3600, "/", "", false, true);
    }

    setFlashAlert('info', 'Anda telah logout.');
    header("Location: " . $baseFolder . "/login");
    exit;
}
