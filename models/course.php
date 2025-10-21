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
    m.title as module_title,
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
function getCourseByIdWithModules2($course_id){
    try {
    $sql = "SELECT 
                c.course_id,
                c.title AS course_title,
                m.module_id,
                m.title AS module_title,
                mc.module_content_id,
                mc.content_type,
                mc.content_data AS module_content
            FROM courses c
            INNER JOIN modules m ON c.course_id = m.course_id
            LEFT JOIN modules_content mc ON mc.module_id = m.module_id
            WHERE c.course_id = ?";

    $rows = runQuery($sql, [$course_id], 'i');

    // Bentuk struktur nested
    $courseData = null;

    foreach ($rows as $row) {
        $courseId = $row->course_id;

        // Inisialisasi data course (sekali saja)
        if ($courseData === null) {
            $courseData = [
                'course_id' => $courseId,
                'title' => $row->course_title,
                'modules' => []
            ];
        }

        // Cek apakah module sudah ada
        $moduleIndex = null;
        foreach ($courseData['modules'] as $i => $mod) {
            if ($mod['module_id'] === $row->module_id) {
                $moduleIndex = $i;
                break;
            }
        }
 
        if ($moduleIndex === null) {
            $courseData['modules'][] = [
                'module_id' => $row->module_id,
                'title' => $row->module_title,
                'contents' => []
            ];
            $moduleIndex = count($courseData['modules']) - 1;
        }
 
        if (!empty($row->module_content_id)) {
            $courseData['modules'][$moduleIndex]['contents'][] = [
                'module_content_id' => $row->module_content_id,
                'content_type' => $row->content_type,
                'module_content' => $row->module_content
            ];
        }
    }

    return [
        'success' => true,
        'data' => $courseData
    ];

} catch (Exception $e) {
    return [
        'success' => false,
        'error' => $e->getMessage()
    ];
}
}
// try {
//     $sql = "SELECT 
//                 c.course_id,
//                 c.title AS course_title,
//                 m.module_id,
//                 m.title AS module_title,
//                 mc.module_content_id,
//                 mc.content_type,
//                 mc.content_data AS module_content
//             FROM courses c
//             INNER JOIN modules m ON c.course_id = m.course_id
//             LEFT JOIN modules_content mc ON mc.module_id = m.module_id
//             WHERE c.course_id = ?";

//     $rows = runQuery($sql, [$course_id], 'i');

//     // Bentuk struktur nested
//     $courseData = null;

//     foreach ($rows as $row) {
//         $courseId = $row->course_id;

//         // Inisialisasi data course (sekali saja)
//         if ($courseData === null) {
//             $courseData = [
//                 'course_id' => $courseId,
//                 'title' => $row->course_title,
//                 'modules' => []
//             ];
//         }

//         // Cek apakah module sudah ada
//         $moduleIndex = null;
//         foreach ($courseData['modules'] as $i => $mod) {
//             if ($mod['module_id'] === $row->module_id) {
//                 $moduleIndex = $i;
//                 break;
//             }
//         }

//         // Kalau belum ada, tambahkan module baru
//         if ($moduleIndex === null) {
//             $courseData['modules'][] = [
//                 'module_id' => $row->module_id,
//                 'title' => $row->module_title,
//                 'contents' => []
//             ];
//             $moduleIndex = count($courseData['modules']) - 1;
//         }

//         // Tambahkan content ke module bersangkutan
//         if (!empty($row->module_content_id)) {
//             $courseData['modules'][$moduleIndex]['contents'][] = [
//                 'module_content_id' => $row->module_content_id,
//                 'content_type' => $row->content_type,
//                 'module_content' => $row->module_content
//             ];
//         }
//     }

//     return [
//         'success' => true,
//         'data' => $courseData
//     ];

// } catch (Exception $e) {
//     return [
//         'success' => false,
//         'error' => $e->getMessage()
//     ];
// }

