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
</head>
<body>
   <form method="post" action="">
    <input type="text" name="email" placeholder="email"
           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    <input type="password" name="password" placeholder="password">
    <button type="submit" name="login">Login</button>
</form>

</body>
</html>