<?php
require_once __DIR__ . '/../helpers/url.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/user.php';

$mysqli = getMysqliConnection();

$baseFolder = basefolder();
$login_token= $_COOKIE['login_token']??NULL;
$userLogin=getUserLogin($login_token)['data']??NULL;

if (!empty($userLogin) && isset($userLogin->created_at)) {
    $userLogin->created_at= date('Y', strtotime($userLogin->created_at));
}


?>