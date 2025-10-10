<?php


function getAllUsers($pdo, $min_id = 1) {
    $sql = "SELECT user_id, name, email FROM users WHERE user_id > :min_id ORDER BY user_id ASC";
    $users = [];  

    try { 
        $stmt = $pdo->prepare($sql);
 
        $stmt->bindValue(':min_id', $min_id, PDO::PARAM_INT);
 
        $stmt->execute();
 
        $users = $stmt->fetchAll();
        
        return [
            'success' => true,
            'data' => $users,
            'message' => 'Data users berhasil diambil.'
        ];

    } catch (\PDOException $e) { 
        return [
            'success' => false,
            'data' => [],
            'message' => "Error saat query: " . $e->getMessage()
        ];
    }
}
?>
