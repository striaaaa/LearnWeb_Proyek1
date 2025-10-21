<?php
require_once __DIR__ . '/../helpers/url.php'; 
require_once __DIR__ . '/../helpers/db_helper.php'; 
 
$baseFolder = basefolder();
 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $token = bin2hex(random_bytes(32));
 
    $userQuery = "SELECT user_id, name, password, role FROM users WHERE email = ?";
    $userResult = runQuery($userQuery, [$email]);

    if (!empty($userResult)) {
        $user = $userResult;
        $storedHash = $user->password;
 
        if (password_verify($password, $storedHash)) { 
            runQuery("UPDATE users SET login_token = ? WHERE user_id = ?", [$token, $user->user_id]);
 
            $newOptions = ['cost' => 12];
            if (password_needs_rehash($storedHash, PASSWORD_DEFAULT, $newOptions)) {
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
                header("Location: " . $baseFolder . "/admin/dashboard");
            } else {
                header("Location: " . $baseFolder . "/");
            }
            exit;
        } else {
            echo "Email atau password salah.";
        }
    } else {
        echo "Email tidak ditemukan.";
    }
}
 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    if (isset($_COOKIE['login_token'])) {
        $token = $_COOKIE['login_token'];
 
        runQuery("UPDATE users SET login_token = NULL WHERE login_token = ?", [$token]);
 
        $_SESSION = [];
        session_destroy();
        setcookie("login_token", "", time() - 3600, "/", "", false, true);
    }

    header("Location: " . $baseFolder . "/login");
    exit;
}
