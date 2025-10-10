<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
 
function get_all_active_courses() {
    $pdo = getMysqliConnection();  
    $courses = [];
    
    try {
        // Query untuk mengambil ID, judul, deskripsi, dan tanggal pembuatan kursus
        $sql = "SELECT course_id, title, description, created_at FROM courses ORDER BY created_at DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        
        return [
            'success' => true, 
            'data' => $courses
        ];

    } catch (\PDOException $e) {
        // Handle error database
        return [
            'success' => false, 
            'message' => "Error saat mengambil kursus: " . $e->getMessage()
        ];
    }
}
?>
