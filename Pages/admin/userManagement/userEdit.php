<?php
// require_once __DIR__.'/../../../middleware/authMiddleware.php'; 
global $params;
$id = $params['id'] ?? null;

if ($id) {
    echo "Edit user dengan ID: " . htmlspecialchars($id);
} else {
    echo "ID user tidak ditemukan.";
}
