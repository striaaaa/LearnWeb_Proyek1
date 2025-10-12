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
            $options = ['cost' => 12]; // cost = tingkat kekuatan hash (default biasanya 10)
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT, $options);
 
            $insert = $mysqli->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            if (!$insert) {
                die("Prepare insert gagal: " . $mysqli->error);
            }
            $roleUser = 'user'; // defalt role
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