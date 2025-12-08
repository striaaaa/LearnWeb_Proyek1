<?php
require_once __DIR__ . '/../helpers/url.php';

require_once __DIR__ . '/../models/user.php';
 
$baseFolder = basefolder();  

$login_token = $_COOKIE['login_token'] ?? NULL;
$userLogin = getUserLogin($login_token)['data'] ?? NULL;
if (!isset($_COOKIE['login_token'])||  !isset($userLogin)) {
    header('Location:' .$baseFolder.'/login');
    exit;
}
