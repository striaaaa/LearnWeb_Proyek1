<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';


function getUserLogin($login_token)
{

    try {
        $sql = "SELECT * FROM users WHERE login_token = ?";

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
function getCourseCompletedUser($user_id){
    try {
        $sql = "
        SELECT 
            c.course_id,
            c.title,
            'Selesai' AS status_course,
            c.image,
            c.description,
            IFNULL(SUM(m.learning_time),0) AS total_learning_time
        FROM courses c
        JOIN modules m ON m.course_id = c.course_id
        LEFT JOIN progress p 
               ON p.module_id = m.module_id 
              AND p.user_id = ?
        GROUP BY c.course_id
        HAVING COUNT(m.module_id) = COUNT(CASE WHEN p.status = 'completed' THEN 1 END)
        ORDER BY c.title ASC
        ";
    
        $userLogin = runQuery($sql, [$user_id], 's');
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
function getUserGroupByMonth($filterYear = null) {
    if ($filterYear === null) {
        $filterYear = date('Y');  
    }
     $users = [];
    try {
        $sql = "SELECT YEAR(created_at) as YEAR, MONTH(created_at) as month, count(*) as total_user from users where year(created_at)=? group by month order by month";
        $users = runQuery($sql,[$filterYear],'i');
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
