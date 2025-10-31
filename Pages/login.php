<?php
require_once __DIR__ . '/../controller/loginController.php';
require_once __DIR__ . '/../middleware/authMiddleware.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="<?= basefolder() ?>/assets/css/login.css" />
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
                <form method="post" >
                    <input type="text" name="email" <?= htmlspecialchars($_POST['email'] ?? '') ?> placeholder="Email" />
                    <br>
                    <br>
                    <input type="password" name="password" placeholder="Password" />
                   
                    <p class="lupa-pw">Lupa Password?</p> 
                    <button class="btn-login" type="submit" name="login">
                        Login
                    </button> 
                    <div class="register">
                        <span>Belum memiliki akun?</span>
                        <a href="<?=basefolder()?>/register">
                            <p class="regist">Daftar disini</p>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div> 

</body>

</html>