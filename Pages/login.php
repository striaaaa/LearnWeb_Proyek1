<?php
require_once __DIR__ . '/../helpers/url.php';
require_once __DIR__ . '/../config/database.php'; 
require_once __DIR__ . '/../middleware/guestMiddleware.php';
$mysqli = getMysqliConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // 1. Ambil user berdasarkan email (prepared statement)
    $stmt = $mysqli->prepare("SELECT user_id, name, password FROM users WHERE email = ?");
    if (!$stmt) {
        die("Prepare gagal: " . $mysqli->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $storedHash = $user['password']; // hash yang tersimpan di DB

        // 2. Verifikasi password
        if (password_verify($password, $storedHash)) { 
            $newOptions = ['cost' => 12];
            // password_needs_rehash buat aapa?
            if (password_needs_rehash($storedHash, PASSWORD_DEFAULT, $newOptions)) {
                $newHash = password_hash($password, PASSWORD_DEFAULT, $newOptions);
                $rehashStmt = $mysqli->prepare("UPDATE users SET password = ? WHERE user_id = ?");
                $rehashStmt->bind_param("si", $newHash, $user['user_id']);
                $rehashStmt->execute();
                $rehashStmt->close();
            }

            // 4. Login sukses -> buat session aman
            // session_regenerate_id(true);
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            echo "Login berhasil. Selamat datang, " . htmlspecialchars($user['name']);
        } else {
            // Password salah
            echo "Email atau password salah.";
        }
    } else {
        // User tidak ditemukan
        echo "Email atau password salah.";
    }

    $stmt->close();
}

$mysqli->close(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <form method="post">
    <input type="text" name="email" placeholder="email"
           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    <input type="password" name="password" placeholder="password">
    <button type="submit" name="login">Login</button>
</form>

</body>
</html>