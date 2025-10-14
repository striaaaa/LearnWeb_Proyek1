<?php
require_once __DIR__ . '/../controller/registerController.php'; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="<?=basefolder()?>/assets/css/login.css" />
    <title>Form Register</title>
</head>

<body> 
    <div class="left">
        <img src="<?=basefolder()?>/assets/login.png" alt="" />
    </div>
    <div class="right">
        <div class="card">
            <div class="header">
                <p>Login</p>
            </div>
            <div class="form">
                <form method="post">
                    <input type="text" name="name" placeholder="Nama Pengguna" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"/>
                    <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>xxcx"/>
                    <input type="password" name="password" placeholder="Password" />
                    <p class="lupa-pw">Lupa Password?</p>
                    <button class="btn-login" type="submit" name="register">
                        Register
                    </button>
                    <div class="register">
                        <span>Sudah memiliki akun?</span>
                        <a href="<?=basefolder()?>/login">
                            <p class="regist">Masuk disini</p>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- <input type="text" name="name" placeholder="Nama lengkap" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"><br>
    <input type="text" name="email" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <button type="submit" name="register">Daftar</button> -->
</body>

</html>