<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';


function getUserLogin($login_token)
{

    try {
        $sql = "SELECT name, email, image, login_token,alamat, created_at FROM users WHERE login_token = ?";

        $userLogin = runQuery($sql, [$login_token], 's');
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
function getUserAll()
{
    $users = [];
    try {
        $sql = "SELECT user_id, name, email, image, alamat, created_at,  CASE 
        WHEN role = 'user' THEN 1 WHEN role IS NULL THEN 0 ELSE 0 END AS is_active FROM users where role = 'user' OR role IS NULL ORDER BY created_at DESC";
        $users = runQuery($sql);
        return [
            'success' => true,
            'data' => $users
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}
