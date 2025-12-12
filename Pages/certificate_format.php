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

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{
      font-family: Inter, Arial, sans-serif;
      background:#fff;
      min-height:100vh;
      padding:20px;
    }

    .card{
      width:100%;
      max-width:1000px;
      margin:auto;
      background:#fff;
      border-radius:8px;
      padding:44px 56px;
      border:1px solid #e5e7eb;
    }

    .accent{
      height:10px;
      background: blue;
      margin-bottom:20px;
    }

    .subtitle{
      text-align:center;
      color:#6b7280;
      font-size:14px;
      margin-bottom:6px;
    }

    .title h1{
      text-align:center;
      font-size:28px;
      font-weight:900;
      font-family: 'Playfair Display', serif;
      color:#0b2545;
    }

    .given{text-align:center;margin-top:20px}
    .given .label{
      font-size:12px;color:#6b7280;letter-spacing:2px;
    }
    .given .name{
      font-family:'Playfair Display', serif;
      font-size:40px;
      margin-top:10px;
      color:#0b2545;
    }

    .meta{margin-top:30px}
    .meta-row{
      display:flex;justify-content:space-between;margin-bottom:12px;
    }
    .meta-row .k{color:#6b7280;font-size:14px}
    .meta-row .v{font-size:14px;text-align:right}

    .note{
      margin-top:20px;
      font-size:14px;
      color:#374151;
      line-height:1.5;
    }
.signatures {
  width:100%;
  margin-top:40px;
  border-top:1px solid #e5e7eb;
  padding-top:20px;
  border-collapse:collapse;
  text-align:center;
}

.signatures td {
  width:33%;
  vertical-align:top;
  padding:10px 5px;
}

.sign .name {
  font-weight:700;
  color:#0b2545;
  font-size:16px;
}

.sign .title {
  color:#6b7280;
  font-size:13px;
}


    .cert-id{
      margin-top:15px;
      text-align:center;
      font-size:12px;
      color:#9ca3af;
    }
  </style>
</head>

<body>
<div class="card">
    <div class="accent"></div>

    <div class="subtitle">Diberikan kepada individu yang telah menyelesaikan program kursus dengan sukses</div>

    <div class="title">
      <h1>E-Certificate</h1>
    </div>

    <div class="given">
      <div class="label">DIBERIKAN KEPADA</div>
      <div class="name"><?= htmlspecialchars($data['user_name']) ?></div>
    </div>

    <div class="meta">
      <div class="meta-row">
        <div class="k">Program Kursus</div>
        <div class="v"><?= htmlspecialchars($data['course_title']) ?></div>
      </div>

      <div class="meta-row">
        <div class="k">Tanggal Penyelesaian</div>
        <div class="v"><?= htmlspecialchars($data['date']) ?></div>
      </div>

      <div class="meta-row">
        <div class="k">Durasi Kursus</div>
        <div class="v"><?= htmlspecialchars($data['duration'] ?? "N/A") ?></div>
      </div>
    </div>

    <div class="note">
      Diberikan atas partisipasi dan penyelesaian tugas selama pelatihan serta kontribusi pada kegiatan yang diselenggarakan.
      Sertifikat ini sah jika digunakan secara elektronik.
    </div>

  <table class="signatures">
  <tr>
    <td class="sign">
        
        <!-- <img src="./image.png" class="sig-img"> -->
         <img src="<?= $data['signature'] ?>" width="150px" class="sig-img">

        <div class="name">Izanagi Faris</div>
        <div class="title">Direktur Pelatihan</div>
    </td>
    
    <td class="sign">
        <!-- <img src="./image.png" class="sig-img"> -->
         <img src="<?= $data['signature'] ?>" width="150px" class="sig-img">

        <div class="name">Satria Sahrul R</div>
        <div class="title">Lead Instructor</div>
    </td>
    
    <td class="sign">
        <!-- <img src="./image.png" class="sig-img"> -->
         <img src="<?= $data['signature'] ?>" width="150px" class="sig-img">
      <div class="name">Sunan M Karim</div>
      <div class="title">Manajer Program</div>
    </td>
  </tr>
</table>

    <!-- <div class="cert-id">ID Sertifikat: <?= htmlspecialchars($data['id'] ?? "0000") ?></div> -->
</div>
</body>
</html>

<?php
// Ambil HTML certificate
$html = ob_get_clean();

PdfHelper::generateCertificatePDF($html, "certificate-" . $data['user_name'] . ".pdf");
exit;
?>
