<?php
require_once __DIR__ . '/../../config/database.php';
// require_once __DIR__.'/../../middleware/authMiddleware.php'; 
$mysqli = getMysqliConnection();
try {
    // $stmt = $mysqli->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    // $name = "Sunin";
    // $email = "123@mail.com";
    // $pass = password_hash("123", PASSWORD_BCRYPT);
    // // "s" = string, "i" = integer, "d" = double, "b" = blob
    // $stmt->bind_param("sss", $name, $email, $pass);
    // $stmt->execute();

    // echo "Insert berhasil, id: " . $stmt->insert_id;
} catch (mysqli_sql_exception $e) {
    echo "Error insert: " . $e->getMessage();
} finally {
    // $stmt->close();
    // $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    admin dashboard
</body>
</html>