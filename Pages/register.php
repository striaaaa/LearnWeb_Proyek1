<?php
require_once __DIR__ . '/../helpers/url.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/guestMiddleware.php';
$mysqli = getMysqliConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validasi sederhana
    if ($name === '' || $email === '' || $password === '') {
        echo "Semua field wajib diisi.";
    } else {
        // 1️⃣ Cek apakah email sudah terdaftar
        $stmt = $mysqli->prepare("SELECT user_id FROM users WHERE email = ?");
        if (!$stmt) {
            die("Prepare gagal: " . $mysqli->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            echo "Email sudah terdaftar. Silakan login.";
        } else {
            // 2️⃣ Hash password dengan cost tertentu
            $options = ['cost' => 12]; // cost = tingkat kekuatan hash (default biasanya 10)
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT, $options);

            // 3️⃣ Insert user baru
            $insert = $mysqli->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            if (!$insert) {
                die("Prepare insert gagal: " . $mysqli->error);
            }
            $roleUser = 'user'; // default role
            $insert->bind_param("ssss", $name, $email, $hashedPassword, $roleUser);
            $insert->execute();

            if ($insert->affected_rows > 0) {
                echo "Registrasi berhasil! Silakan login.";
            } else {
                echo "Registrasi gagal. Coba lagi.";
            }

            $insert->close();
        }

        $stmt->close();
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Register</title>
</head>
<body>
    <h2>Form Registrasi</h2>
    <form method="post">
        <input type="text" name="name" placeholder="Nama lengkap" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"><br>
        <input type="text" name="email" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"><br>
        <input type="password" name="password" placeholder="Password"><br>
        <button type="submit" name="register">Daftar</button>
    </form>
</body>
</html>
