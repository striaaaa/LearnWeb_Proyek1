<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

 
function getUserLogin($login_token)
{

    try {
        $sql = "SELECT name, email, image, login_token,alamat, created_at FROM users WHERE login_token = ?";

        $userLogin = runQuery($sql, [$login_token], 'ss'); 
        return [
            'success' => true,
            'data' => $userLogin
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}