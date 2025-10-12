<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';


$mysqli = getMysqliConnection();
$stmt= $mysqli->prepare("SELECT name, email, image, login_token FROM users WHERE login_token = ?");
if (!$stmt) {
    die("Prepare gagal: " . $mysqli->error);
} 
$stmt->bind_param("s", $_COOKIE['login_token']);
$stmt->execute();
$result = $stmt->get_result();
// var_dump($result);
if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();
} 