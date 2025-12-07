<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

function getAllCourses()
{
    $courses = [];
    try {
        $sql = "SELECT course_id, title, description,image,   DATE(created_at) AS created_at FROM courses ORDER BY created_at DESC";
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
function getModuleswithContent($course_id)
{
    try {
        $sqlModules = "SELECT *
                       FROM modules where course_id=?
                       ORDER BY created_at DESC  ";

        $modules = runQuery($sqlModules, [$course_id], 'i');
        if (!$modules) {
            return [
                'success' => true,
                'data' => []
            ];
        }
        foreach ($modules as $module) {
            $moduleId = $module->module_id;
            $sqlModules = "SELECT module_id, content_data 
                           FROM modules_content 
                           WHERE module_id = ?
                           ORDER BY created_at ASC ";

            $modulesContent = runQuery($sqlModules, [$moduleId]);

            $module->modulesContent = $modulesContent ?? [];
        }

        return [
            'success' => true,
            'data' => $modules,
            'courseData'=>getCourseByid($course_id)['data']
        ];
    } catch (\Exception $e) {
        return [
            'success' => false,
            'message' => "Error mengambil data: " . $e->getMessage()
        ];
    }
}
function getCourseByid($course_id)
{
    try {
        $sql = "SELECT course_id, title, description,image, created_at FROM courses WHERE course_id=?";
        $course = runQuery($sql, [$course_id], 'i');
        return [
            'success' => true,
            'data' => $course
        ];
    } catch (\Exception $e) {
        // Handle error database
        return [
            'success' => false,
            'message' => "Error saat mengambil kursus: " . $e->getMessage()
        ];
    }
}
function getCoursesWithModulesLimit3()
{
    try {
        $sqlCourses = "SELECT course_id, title, description, image, created_at 
                       FROM courses 
                       ORDER BY created_at DESC 
                       LIMIT 3";

        $courses = runQuery($sqlCourses);
        if (!$courses) {
            return [
                'success' => true,
                'data' => []
            ];
        }
        foreach ($courses as &$course) {
            $courseId = $course->course_id;

            $sqlModules = "SELECT module_id, title 
                           FROM modules 
                           WHERE course_id = ?
                           ORDER BY created_at ASC LIMIT 3";
            // $sqlModules = "SELECT module_id, title 
            //                FROM modules 
            //                WHERE course_id = ?
            //                ORDER BY created_at ASC LIMIT 3";

            $modules = runQuery($sqlModules, [$courseId]);

            $course->modules = $modules ? $modules : [];
        }

        return [
            'success' => true,
            'data' => $courses
        ];
    } catch (\Exception $e) {
        return [
            'success' => false,
            'message' => "Error mengambil data: " . $e->getMessage()
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

function getCourseByIdWithModules2($course_id, $user_id)
{
    try {
        $sql = "SELECT 
    c.course_id,
    c.title AS course_title,
    m.module_id,
    m.course_id,
    m.order_no AS order_no,
    m.title AS module_title,
    mc.module_content_id,
    mc.content_type,
    mc.content_data AS module_content,
    p.status AS progress_status,
    p.updated_at AS progress_updated_at
FROM courses c
INNER JOIN modules m 
    ON c.course_id = m.course_id
LEFT JOIN modules_content mc 
    ON mc.module_id = m.module_id
LEFT JOIN progress p 
    ON p.module_id = m.module_id 
    AND p.user_id = ?
WHERE c.course_id = ?
ORDER BY m.order_no ASC;
";

        $rows = runQuery($sql, [$user_id, $course_id], 'ii');

        if (empty($rows)) {
            return (object)[
                'success' => false,
                'message' => 'Course tidak ditemukan.'
            ];
        }


        if (is_object($rows)) {
            $rows = [$rows];
        }
        $courseData = (object)[
            'course_id' => $rows[0]->course_id??null,
            'title' => $rows[0]->course_title??null,
            'modules' => []
        ];

        foreach ($rows as $row) {
            $moduleIndex = null;
            foreach ($courseData->modules as $i => $mod) {
                if ($mod->module_id === $row->module_id) {
                    $moduleIndex = $i;
                    break;
                }
            }
            if ($moduleIndex === null) {
                $status = $row->progress_status??null; 
                if ($status === "completed") {
                    $finalStatus = "completed";
                } elseif ($status === "in_progress") {
                    $finalStatus = "in_progress";
                } else {
                    $finalStatus = "locked";  
                }
                $newModule = (object)[
                    'course_id' => $row->course_id ??null,
                    'module_id' => $row->module_id ??null,
                    'progress_status' => $finalStatus ??null,
                    'title' => $row->module_title??null,
                    'order_no' => $row->order_no??null,
                    'contents' => []
                ];
                $courseData->modules[] = $newModule;
                $moduleIndex = count($courseData->modules) - 1;
            }

            if (!empty($row->module_content_id)) {
                $courseData->modules[$moduleIndex]->contents[] = (object)[
                    'module_content_id' => $row->module_content_id,
                    'content_type' => $row->content_type,
                    'module_content' => $row->module_content
                ];
            }
        }

        return (object)[
            'success' => true,
            'data' => $courseData
        ];
    } catch (Exception $e) {
        return (object)[
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}


function getCourseWithModules2()
{
    try {
        $sql = "SELECT 
                    c.course_id,
                    c.title AS course_title,
                    c.description,
                    DATE_FORMAT(c.created_at, '%Y-%m-%d') AS formated_created_at,
                    m.module_id,
                    m.title AS module_title,
                    m.learning_time as learning_time,
                    mc.module_content_id,
                    mc.content_type,
                    mc.content_data AS module_content
                FROM courses c
                LEFT JOIN modules m ON c.course_id = m.course_id
                LEFT JOIN modules_content mc ON mc.module_id = m.module_id
                ORDER BY c.course_id, m.order_no, mc.module_content_id";

        $rows = runQuery($sql);

        if (!$rows) {
            return [
                'success' => false,
                'data' => [],
                'message' => 'Tidak ada data ditemukan.'
            ];
        }

        if (!is_array($rows)) {
            $rows = [$rows];
        }

        $courseData = [];

        foreach ($rows as $row) {
            $courseId = $row->course_id;
            $moduleId = $row->module_id;
            

            if (!isset($courseData[$courseId])) {
                $courseData[$courseId] = [
                    'course_id' => $courseId,
                    'title' => $row->course_title,
                    'description' => $row->description,
                    'created_at' => $row->formated_created_at,
                    'modules' => []
                ];
            }
            if ($moduleId !== null) {
    if (!isset($courseData[$courseId]['modules'][$moduleId])) {
        $courseData[$courseId]['modules'][$moduleId] = [
            'module_id' => $moduleId,
            'title' => $row->module_title,
            'learning_time' => $row->learning_time .' Menit',
            'contents' => []
        ];
    }

    if (!empty($row->module_content_id)) {
        $courseData[$courseId]['modules'][$moduleId]['contents'][] = [
            'module_content_id' => $row->module_content_id,
            'content_type' => $row->content_type,
            'module_content' => $row->module_content
        ];
    }
}

        }

        foreach ($courseData as &$course) {
            $course['modules'] = array_values($course['modules']);
        }

        return [
            'success' => true,
            'data' => arrayToObject(array_values($courseData))
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
