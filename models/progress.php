<?php 
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';


function getUserProgresCheck($user_id, $module_id)
{

    try {
        $sql = "SELECT * from progress where user_id=? and module_id=? limit 1";

        $userLogin = runQuery($sql, [$user_id, $module_id], 'ii');
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
function getUserLastProgres($user_id)
{

    try {
        $sql = "SELECT * from progress where user_id=? order by progress_id desc limit 1";

        $userLogin = runQuery($sql, [$user_id], 'i');
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

function prevModuleExist($order_no)
{

    try {
        $sql = "SELECT * from modules where order_no=? limit 1";

        $userLogin = runQuery($sql, [$order_no], 'i');
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