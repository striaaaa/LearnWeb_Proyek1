<?php
require_once __DIR__ . '/../controller/dashboardController.php';
require_once __DIR__ . '/../middleware/guestMiddleware.php';
$page_css = '<link rel="stylesheet" href="assets/css/dashboard.css" />';
ob_start();
?> 
    <div class="container-profile">
      <div class="img-radius">
        <img src="" alt="user" />
      </div>
      <div class="detail-profile">
      
        <h1><?=$userLogin->name?></h1>
        <div class="bergabung">
          <i class="ri-calendar-2-fill"></i>
          <span>Bergabung sejak <?=$userLogin->created_at?></span>
        </div>
        <div class="bergabung">
          <i class="ri-map-pin-2-fill"></i>
          <span><?=$userLogin->alamat?></span>
        </div>
      </div>
    </div>

    <div class="modul-success">
      <div class="content-modul">
        <div class="top-content">
          <div class="img-left-modul">
            <img src="" alt="ajdaskjdas" />
          </div>
          <div class="title-modul">
            <span><i class="ri-check-line"></i>Selesai</span>
            <p class="nigga">Pengenalan Html dasar</p>
            <span class="jam"><i class="ri-time-line"></i>45 Jam</span>
          </div>
        </div>
        <p class="desc-modul">
          Mempelajari komponen - komponen dasar Html dan CSS yang Merupakan
          fondasi utama untuk menjadi front-end web developer
        </p>
        <div class="btn-download">Unduh Materi</div>
      </div>
      
      <div class="content-modul">
        <div class="top-content">
          <div class="img-left-modul">
            <img src="" alt="ajdaskjdas" />
          </div>
          <div class="title-modul">
            <span><i class="ri-check-line"></i>Selesai</span>
            <p>Pengenalan Html dasar</p>
            <span class="jam"><i class="ri-time-line"></i>45 Jam</span>
          </div>
        </div>
        <p class="desc-modul">
          Mempelajari komponen - komponen dasar Html dan CSS yang Merupakan
          fondasi utama untuk menjadi front-end web developer
        </p>
        <div class="btn-download">Unduh Materi</div>
      </div>
    </div>

    <div class="line"></div> 
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/mainUser.php';
?>
