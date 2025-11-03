<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';


function getAllModuleContent($module_id)
{

    try {
        $sql = "SELECT * FROM modules_content WHERE module_id = ?";

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