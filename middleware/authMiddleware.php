<?php
require_once __DIR__ . '/../helpers/url.php';
 
$baseFolder = basefolder();
if (isset($_COOKIE['login_token'])) {
    header('Location:' .$baseFolder.'/');
    exit;
}
 