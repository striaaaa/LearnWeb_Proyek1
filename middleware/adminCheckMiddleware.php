<?php
require_once __DIR__ . '/../helpers/url.php';
require_once __DIR__ . '/../models/user.php';
 
$baseFolder = basefolder();
$cookieData= $_COOKIE['login_token'];
$userLogin = getUserLogin($cookieData);
if (isset($_COOKIE['login_token'])&& $userLogin['data']->role !== 'admin') {
    header('Location:' .$baseFolder.'/');
    // echo "Access denied. Admins only.";
    exit;
}
 