<?php
session_start();
require_once __DIR__."../../helpers/PdfHelper.php";

if (!isset($_SESSION['certificate_data'])) {
    die("Tidak ada data sertifikat.");
}

$data = $_SESSION['certificate_data'];

// Mulai capture HTML
ob_start();
?>

<!DOCTYPE html>
<html>
<head>
<style>
body {
    width: 100%;
    height: 100%;
    text-align: center;
    padding: 50px;
    background: url('../assets/certificate-bg.png') no-repeat center;
    background-size: cover;
    font-family: 'Times New Roman';
}
.title {
    font-size: 40px;
    font-weight: bold;
}
.name {
    font-size: 32px;
    margin-top: 40px;
    font-weight: bold;
}
.course {
    font-size: 24px;
    margin-top: 10px;
}
.date {
    margin-top: 60px;
    font-size: 18px;
}
</style>
</head>

<body>
    <div class="title">SERTIFIKAT</div>
    <div class="name"><?= $data['user_name'] ?></div>
    <div class="course">Menyelesaikan: <?= $data['course_title'] ?></div>
    <div class="date">Tanggal: <?= $data['date'] ?></div>
</body>
</html>

<?php
// Ambil HTML certificate
$html = ob_get_clean();

PdfHelper::generateCertificatePDF($html, "certificate-" . $data['user_name'] . ".pdf");
exit;
?>
