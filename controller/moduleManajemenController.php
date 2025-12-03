<?php

require_once __DIR__ . '/../helpers/url.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/course.php';


$courseWithModulesResult = getCourseWithModules2();

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$action = $_POST['action'] ?? '';
$title = $_POST['title'] ?? '';
$module_id = $_POST['module_id'] ?? '';
$course_id = $_POST['course_id'] ?? '';
// $orders_no = $_POST['orders_no']??'s';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orders_no = json_decode($_POST['orders_no'] ?? '[]');
    switch ($action) {
        case 'addModuleTitle':
            addModuleTitle($title, $course_id);
            break;
        case 'updateModuleTitle':
            updateModuleTitle($title, $module_id);
            break;
        case 'updateModuleOrder':
            updateModuleOrder($course_id, $orders_no);
            break;
        case 'deleteModule':
            echo 'as';
            deleteModule($module_id, $course_id);
            break;
        default:
            break;
    }
}
function addModuleTitle($title, $course_id)
{
    try {
        // var_dump($title,$course_id);
        // die;
        if (!$title || !$course_id) {
            die('Data modul tidak lengkap!');
        }
        $sqlLastOrder = "SELECT MAX(order_no) as last_order FROM modules WHERE course_id = ?";
        $lastOrderResult = runQuery($sqlLastOrder, [$course_id], 'i');
        // var_dump($lastOrderResult);
        $lastOrderNo = $lastOrderResult->last_order ?? 0;
        $sqlInsert = "INSERT INTO modules (title, course_id, order_no) VALUES (?, ?, ?)";
        $addedModule = runQuery($sqlInsert, [$title, $course_id, $lastOrderNo + 1], 'sii');
        header('Location: ' . basefolder() . '/admin/manajemen-modul');
    } catch (\Exception $e) {
        echo 'Error:' . $e->getMessage();
    }
}
function updateModuleTitle($title, $module_id)
{
    try {
        if (!$title) {
            die('Data modul belum lengkap!');
        }
        echo $title . ' - ' .  $module_id;
        $sql = "UPDATE modules set title=? WHERE module_id=?";
        $updatedModule = runQuery($sql, [$title, $module_id], 'si');
        //    header("Location: ../views/courses_list.php?success=1");
        header('Location: ' . basefolder() . '/admin/manajemen-modul');
        var_dump($updatedModule);
        echo 'title modul berhasil diperbarui.';

        exit;
    } catch (\Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
function updateModuleOrder($course_id, $module_ids)
{
    try {
        if (!$course_id) {
            die('Data modul belum lengkap!');
        }
        $sql = "UPDATE modules set order_no=? WHERE module_id=? AND course_id=?";
        foreach ($module_ids as $index => $module_id) {
            # code...
            $orderIndex = $index + 1;
            echo $module_id;
            $updatedModule = runQuery($sql, [$orderIndex, $module_id, $course_id], 'isi');
        }
        //    header("Location: ../views/courses_list.php?success=1");
        header('Location: ' . basefolder() . '/admin/manajemen-modul');
        var_dump($updatedModule);
        echo 'title modul berhasil diperbarui.';

        exit;
    } catch (\Exception $e) {
        // Handle error database
        echo 'Error: ' . $e->getMessage();
    }
}
function deleteModule($module_id, $course_id)
{
    try {
        if (!$module_id) {
            die('Data modul belum lengkap!');
        }

        $sql = "DELETE FROM modules WHERE module_id=?";
        //udh cascade on delete dari db
        $deletedModule = runQuery($sql, [$module_id], 'i');
        $reorderSql = "UPDATE modules AS m
    JOIN (
        SELECT module_id, (@row := @row + 1) AS new_order
        FROM modules, (SELECT @row := 0) AS r
        WHERE course_id = ?
        ORDER BY created_at ASC
    ) AS x ON m.module_id = x.module_id
    SET m.order_no = x.new_order";;
        //    $reorderSql = "SET @row = 0; UPDATE modules SET order_no = (@row := @row + 1) WHERE course_id = ? ORDER BY order_no ASC;";
 
        runQuery($reorderSql, [$course_id], "i");
        header('Location: ' . basefolder() . '/admin/manajemen-msodul?success=1');
        // echo $deletedModule;
        echo 'Modul berhasil dihapus.';

        exit;
    } catch (\Exception $e) {
        // Handle error database
        echo 'Error: ' . $e->getMessage();
    }
}
// var_dump($courseWithModulesResult['data']);
