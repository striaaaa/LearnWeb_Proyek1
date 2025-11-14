<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

function getAllModuleContent($course_id, $module_id)
{
    try {
        // Cek apakah modul ini memang milik course_id yang diminta
        $checkSql = "SELECT course_id FROM modules WHERE module_id = ?";
        $module = runQuery($checkSql, [$module_id], 'i');

        // var_dump($module);
        if (empty($module)) {
            return ['success' => false, 'error' => 'Modul tidak ditemukan.'];
        }

        // Pastikan modulnya milik course yang sama
        if ($module->course_id != $course_id) {
            return ['success' => false, 'error' => 'Modul tidak termasuk dalam kursus ini.'];
        }

        // Jika valid, ambil semua konten modul
        $sql = "SELECT * FROM modules_content WHERE module_id = ? ORDER BY order_no ASC";
        $allContent = runQuery($sql, [$module_id], 'i');

        return [
            'success' => true,
            'data' => $allContent
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}
