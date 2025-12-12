<?php
require_once __DIR__ . '/../helpers/db_helper.php';
require_once __DIR__ . '/../helpers/url.php';

function log_access_db_runQuery($userId = null, $route = null) {
     $db= getMysqliConnection();

    $route = $route ?? ($_SERVER['REQUEST_URI'] ?? 'unknown'); 
$allowedIP = "180.245.31.190" ;
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'unknown';

if ($ip !==$allowedIP) {
    echo '<script>
        console.log("haihitam 123");
        alert("maintenece bangg sabar");
    </script>';
    die;
}
// if ($ip === $allowedIP2) {
//     echo '<script>
//         console.log("haihitam 123");
//         alert("ini hp husen");
//     </script>';
// }
    // Ambil IP asli / fallback

    // Anonymize IP (hapus digit terakhir)
    // if (filter_var($ip, FILTER_VALIDATE_IP)) {
    //     $ip_parts = explode('.', $ip);
    //     if (count($ip_parts) === 4) {
    //         $ip = implode('.', array_slice($ip_parts, 0, 3)) . '.0';
    //     }
    // }

    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
 
    $tableExists = false;
    $result = $db->query("SHOW TABLES LIKE 'access_logs'");
    if ($result && $result->num_rows > 0) {
        $tableExists = true;
    }

    if (!$tableExists) {
        return;  
    }
 
    $stmt = $db->prepare("INSERT INTO access_logs (user_id, ip_address, route, user_agent) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('isss', $userId, $ip, $route, $userAgent);
    $stmt->execute();
    $stmt->close();
}
