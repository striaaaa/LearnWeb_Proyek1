<?php
global $params;
$id = $params['slug'] ?? null;

if ($id) {
    echo "slug dengan ID: " . htmlspecialchars($id);
} else {
    echo "slug tidak ditemukan.";
}
