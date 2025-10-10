<?php
global $params;
$id = $params['segment'] ?? null;

if ($id) {
    echo "ini segmen dengan ID: " . htmlspecialchars($id);
} else {
    echo "segmeen tidak ditemukan.";
}
