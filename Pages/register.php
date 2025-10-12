<?php
require_once __DIR__ . '/../controller/registerController.php'; 
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
