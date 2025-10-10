<?php
require_once __DIR__ . '/../helpers/url.php';

session_start();
$uri = $_SERVER['REQUEST_URI'];  

$segments = explode('/', trim($uri, '/'));  

$baseFolder = '/' . $segments[0];   
if (!isset($_SESSION['user_id'])) {
    header('Location:' .$baseFolder.'/login');
    exit;
}
 