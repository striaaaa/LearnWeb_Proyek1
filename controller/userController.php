<?php

require_once __DIR__ . '/../helpers/url.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/user.php';

// global $params;
// $id = $params['courseId'] ?? null;
$userAll = getUserAll();
$user_id = $_POST['user_id'] ?? null;
$isActive = $_POST['isActiveInput'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    switch ($action) {
        case 'create':
            break;
        case 'updateStatusUser':
           
            $updateStatusUserResult = updateStatusUser($user_id, $isActive);
            break;
        case 'delete':
            break;
    }

    header("Location: " . baseFolder() . "/admin/manajemen-pengguna");
    exit;
}

function updateStatusUser($user_id, $isActive)
{
    // var_dump($user_id, $isActive);
    // die();
    try {
        echo $isActive;
        echo 'userirf'.$user_id;
        $isActiveCheck = ($isActive == 1) ? 'user' : NULL; 
        $updatedUser=null;
        if (is_null($isActiveCheck)) { 
            $sql = "UPDATE users SET role = NULL WHERE user_id = ?"; 
            $updatedUser=runQuery($sql, [$user_id], 'i'); 
            echo "if";
        } else { 
            $sql = "UPDATE users SET role = ? WHERE user_id = ?";
            $updatedUser= runQuery($sql, ['user', $user_id], 'si');  
            echo "else";
        }

        // die();
        var_dump($updatedUser);
        echo 'Status user berhasil diperbarui.';
        return [
            'success' => true,
            'message' => "Status user berhasil diperbarui."
        ];
    } catch (\Exception $e) {
        // Handle error database
        echo 'Error: ' . $e->getMessage();
        return [
            'success' => false,
            'message' => "Error saat memperbarui status user: " . $e->getMessage()
        ];

    }
}

// var_dump($courseWithModulesResult['data']);
