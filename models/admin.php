<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
function countTotalCourses()
{
    try {
        $sql = "SELECT COUNT(*) AS total_courses FROM courses";
        $countData = runQuery($sql);

        return [
            'success' => true,
            'data' => $countData
        ];
    } catch (Exception $e) {

        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}
function countTotalModules()
{
    try {
        $sql = "SELECT COUNT(*) AS total_modules FROM modules";
        $countData = runQuery($sql);

        return [
            'success' => true,
            'data' => $countData
        ];
    } catch (Exception $e) {

        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}

function countTotalUsers()
{
    try {
        $sql = "SELECT COUNT(*) AS total_users FROM users";
        $countData = runQuery($sql);

        return [
            'success' => true,
            'data' => $countData
        ];
    } catch (Exception $e) {

        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}

function userCourseCompleted()
{
    try {
        $sql = "SELECT 
    c.course_id,
    c.title,
    COUNT(*) AS total_user_selesai
FROM courses c
JOIN (
    SELECT 
        p.user_id,
        m.course_id
    FROM progress p
    JOIN modules m ON p.module_id = m.module_id
    WHERE p.status = 'completed'
    GROUP BY p.user_id, m.course_id
    HAVING COUNT(*) = (
        SELECT COUNT(*) FROM modules m2 WHERE m2.course_id = m.course_id
    )
) AS t ON t.course_id = c.course_id
GROUP BY c.course_id, c.title;
";
        $dataCourse = runQuery($sql);

        return [
            'success' => true,
            'data' => $dataCourse
        ];
    } catch (Exception $e) {

        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}
