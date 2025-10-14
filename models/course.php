<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

function getAllCourses()
{ 
    $courses = [];

    try {
        // Query untuk mengambil ID, judul, deskripsi, dan tanggal pembuatan kursus
        $sql = "SELECT course_id, title, description, created_at FROM courses ORDER BY created_at DESC";
        $courses = runQuery($sql);


        return [
            'success' => true,
            'data' => $courses
        ];
    } catch (\Exception $e) {
        // Handle error database
        return [
            'success' => false,
            'message' => "Error saat mengambil kursus: " . $e->getMessage()
        ];
    }
}
function getCourseByIdWithModules($course_id)
{

    try {
        $sql = "SELECT  c.course_id,
    c.title,
    m.module_id,
    m.title,
    mc.module_content_id,
    mc.content_type,
    mc.content_data AS module_content FROM courses c 
            INNER JOIN modules m ON c.course_id = m.course_id  LEFT JOIN modules_content mc ON mc.module_id = m.module_id
WHERE mc.module_content_id = (
    SELECT mc2.module_content_id as module_content
    FROM modules_content mc2
    WHERE mc2.module_id = m.module_id
    ORDER BY mc2.created_at asc
    LIMIT 1
)
AND c.course_id = ?";

        $courses = runQuery($sql, [$course_id], 'i');
        // Gunakan koneksi utama, bukan $stmt
        // $stmt = $mysqli->prepare($sql);
        // $stmt->bind_param("i", $course_id);
        // $stmt->execute(); // execute dulu

        // $result = $stmt->get_result(); // baru ambil hasil
        // $courses = [];
        // var_dump($result); 
        // while ($row = $result->fetch_assoc()) {
        //     $courses[] = $row;
        // }

        //     $mysqli->close();
        //     $stmt->close();
        return [
            'success' => true,
            'data' => $courses
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}
