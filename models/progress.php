<?php 
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';


function getUserProgresCheck($user_id, $module_id)
{

    try {
        $sql = "SELECT * from progress where user_id=? and module_id=? limit 1";

        $userLogin = runQuery($sql, [$user_id,$module_id], 'ii',  true, 'auto');
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

        $userLogin = runQuery($sql, [$user_id], 'i', true, 'auto');
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

function prevModuleExist($module_id,$order_no)
{

    try {
        $sql = "SELECT * from modules where module_id=? and order_no=? limit 1";
        $order_no= ($order_no==0)?1:$order_no;
        $userLogin = runQuery($sql, [$module_id,$order_no], 'ii', '', 'single');
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
function getUserCourseProgress($user_id, $course_id)
{   
    $sqlTotal = "SELECT COUNT(*) as total FROM modules WHERE course_id = ?";
    $total = runQuery($sqlTotal, [$course_id], 'i')->total ?? 0; 
    $sqlCompleted = "SELECT COUNT(*) as completed 
                     FROM progress 
                     JOIN modules ON modules.module_id = progress.module_id
                     WHERE progress.user_id = ? 
                     AND modules.course_id = ?
                     AND progress.status = 'completed'";

    $completed = runQuery($sqlCompleted, [$user_id, $course_id], 'ii')->completed ?? 0;
 
    $percentage = ($total > 0) ? round(($completed / $total) * 100) : 0;

    return [
        'total' => $total,
        'completed' => $completed,
        'percentage' => $percentage
    ];
}
