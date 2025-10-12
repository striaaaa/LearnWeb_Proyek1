<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail-Modul</title>
    <link rel="stylesheet" href="../style/nav.css" />
    <link rel="stylesheet" href="../style/detail-modul.css" />
    <!-- Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sora:wght@100..800&display=swap"
      rel="stylesheet"
    />
    <!-- ICON -->
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css"
      rel="stylesheet"
    />
  </head>
  <body>
    <div class="nav">
      <div class="logo">Logo</div>
      <div class="nav-link">
        <a href="after-login.html"><span>Beranda</span></a>
        <a href="learning-path.html"><span>Learning Path</span></a>
        <a href=""><span>Dashboard</span></a>
      </div>
      <div class="acc-nav">
        <div class="name-acc-nav">
          <span>Nama Akun</span>
        </div>
        <div class="img-acc-nav">
          <img src="../assets/user.png" alt="user" />
        </div>
      </div>
    </div>

    <div class="nav-detail-modul">
      <div class="left-nav-detail">
        <i class="ri-arrow-left-line"></i>
        <span>Pengenalan Html</span>
      </div>
      <div class="nav-theme">
        <button id="toggleButton" class="btn-theme">
          <i id="icon" class="ri-sun-fill" style="font-size: 24px"></i>
        </button>
      </div>
    </div>

    <div class="container-detail">
      <div class="frame">
        <h1>Apa itu Html?</h1>
        <p>
          HTML adalah singkatan dari HyperText Markup Language, yaitu bahasa
          markup standar untuk membuat struktur halaman web. Dengan HTML, kita
          bisa menampilkan teks, gambar, link, tabel, hingga video di browser.
          Tanpa HTML, browser tidak akan tahu bagaimana menampilkan konten web.
          Jadi bisa dibilang HTML itu pondasi dasar dari semua website.
        </p>
      </div>
      <div class="frame">
        <h1>Poin Penting</h1>
        <ul>
          <li>HTML bukan bahasa pemrograman, melainkan bahasa markup.</li>
          <li>
            HTML menggunakan tag untuk menandai elemen (contoh: p untuk
            paragraf).
          </li>
          <li>
            Browser membaca kode HTML dari atas ke bawah lalu menampilkannya ke
            layar.
          </li>
        </ul>
      </div>
      <div class="frame">
        <h1>Contoh Kode</h1>
        <div class="bingkai">
          <img src="../assets/html-1.png" alt="" />
        </div>
      </div>
      <div class="frame">
        <h1>Analogi Sederhana</h1>
        <p>
          Bayangkan HTML itu seperti tulang dalam tubuh manusia → memberi
          struktur.Supaya terlihat menarik, HTML butuh CSS (ibarat pakaian),
          dan agar interaktif, HTML butuh JavaScript (ibarat otot).
        </p>
      </div>
      <div class="frame">
        <h1>Ringkasan</h1>
        <ul>
          <li>HTML = pondasi semua website.</li>
          <li>Digunakan untuk membuat struktur konten di halaman web.</li>
          <li>Menggunakan tag untuk menandai elemen.</li>
          <li>Sudah bisa dipakai untuk membuat halaman sederhana.</li>
        </ul>
      </div>
    </div>

    <div class="foot-nav">
      <div class="left-nav-detail">
        <i class="ri-arrow-left-line"></i>
        <span>Pengenalan Html</span>
      </div>
      <div class="right-nav-detail">
        <span>Selanjutnya</span>
        <i class="ri-arrow-right-line"></i>
      </div>
    </div>
    <!-- SCRIPT -->
    <script src="../script.js"></script>
  </body>
</html>
