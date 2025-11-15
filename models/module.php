<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';


function getModuleById($module_id)
{

    try {
        $sql = "SELECT * from modules where module_id=? limit 1";

        $dataModule = runQuery($sql, [$module_id], 'i');
        return [
            'success' => true,
            'data' => $dataModule
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}
function getModuleByCourseIdAscLimit1($course_id)
{

    try {
         $sql = "SELECT * FROM modules WHERE course_id = ? order by module_id asc LIMIT 1";
    $dataQuery =runQuery($sql, [$course_id], 'i');
        return [
            'success' => true,
            'data' => $dataQuery
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}
function getModuleByOrder($course_id,$order_no)
{

    try {
         $sql = "SELECT * FROM modules WHERE course_id = ? AND order_no = ? LIMIT 1";
    $dataQuery =runQuery($sql, [$course_id, $order_no], 'ii', true);
        return [
            'success' => true,
            'data' => $dataQuery
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}