<?php
function getMysqliConnection() {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $mysqli = new mysqli('localhost', 'root', '', 'learnweb');
        $mysqli->set_charset('utf8mb4');
        return $mysqli;
    } catch (mysqli_sql_exception $e) {
        die("Koneksi database GAGAL: " . $e->getMessage());
    }
}
?>
