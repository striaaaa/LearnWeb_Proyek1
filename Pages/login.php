<?php
require_once __DIR__ . '/../controller/loginController.php';
require_once __DIR__ . '/../middleware/authMiddleware.php';
// require_once __DIR__ . '/../components/alert.php';
 renderFlashAlert(); 

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
        <img src="<?= basefolder() ?>/assets/login.png" alt="" />
    </div>
    <div class="right">
        <div class="card">
            <div class="header">
                <p>Login</p>
            </div>
            <div class="form">
                <form id="loginForm" method="post">
                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="Email" required />
                    <br><br>
                    <input type="password" name="password" id="password" placeholder="Password" required />
                    <p class="lupa-pw">Lupa Password?</p>
                    <button class="btn-login" type="submit" name="login">Login</button>
                </form>
                 <div class="register">
                        <span>Belum memiliki akun?</span>
                        <a href="<?=basefolder()?>/register">
                            <p class="regist">Daftar disini</p>
                        </a>
                    </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
  
</script>