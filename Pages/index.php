<?php
require_once __DIR__ . '/../controller/homepageController.php';
// require_once __DIR__ . '/../middleware/guestMiddleware.php';

$page_css  = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/home.css">';
ob_start();
?>

<!-- diimport dri middleware -->
<? #=basefolder();
?>

<div class="container-1">
  <div class="left_content_1">
    <div class="header_content_1">
      <p>Belajar Web Development Dasar dengan Mudah</p>
    </div>
    <div class="sub_header_content_1">
      <p>Materi terstruktur untuk mahasiswa baru Teknik Informatika</p>
    </div>
    <a href="<?= basefolder() ?>/course" class="btn_content_1">
      <span>Belajar Sekarang</span>
    </a>
  </div>
  <div class="right_content_1">
    <div class="box-img-1">
      <img src="<?=basefolder() ?>/assets/image22.png" alt="ini gambar" />
    </div>
  </div>
</div>

<div class="container-2">
  <div class="header_content_2">
    <p>Mulai Belajar dari sini</p>
  </div> 
  <div class="container-card-2"> 

    <?php foreach ($allCourseWithModules["data"] as $course): ?>
      <div class="card_content_2"> 
        <div class="head_card_2">
          <img src="<?= basefolder() ?>/uploads/admin/<?= $course->image ?>" 
          alt="<?= $course->title ?>" />
        </div> 
        <div class="desc_card_2">
          <?php foreach ($course->modules as $module): ?>
            <!-- <?= var_dump($module)?>
            <?php if(empty((array)$module->title??'')): ?> -->
              <!-- <div>modul tidak lengkap</div> -->
              <!-- <?php else:?>
                <?php endif; ?> -->
                <p><?= $module->title??'module tidak ada' ?></p>
            <?php endforeach; ?>
        </div> 
        <a href="<?= basefolder() ?>/course" style="text-decoration:none;" class="btn_card_2">
            <p>Lihat Modul</p>
        </a>
    </div>

<?php endforeach; ?>

</div>

  <div class="container-card-2">
    <!-- <div class="card_content_2">
      <div class="head_card_2"> <img src="<?= basefolder() ?>/assets/card-1.png" alt=""></div>
      <div class="desc_card_2">
        <p>Pengenalan & Struktur Html</p>
        <p>Pengenalan & Struktur Html</p>
        <p>Pengenalan & Struktur Html</p>
        <p>Pengenalan & Struktur Html</p>
      </div>
      <div class="btn_card_2">
        <p>Lihat Modul</p>
      </div>
    </div>
    <div class="card_content_2">
      <div class="head_card_2">
        <img src="<?= basefolder() ?>/assets/card-2.png" alt="">
      </div>
      <div class="desc_card_2">
        <p>Pengenalan & Struktur Html</p>
        <p>Pengenalan & Struktur Html</p>
        <p>Pengenalan & Struktur Html</p>
        <p>Pengenalan & Struktur Html</p>
      </div>
      <div class="btn_card_2">
        <p>Lihat Modul</p>
      </div>
    </div>
    <div class="card_content_2">
      <div class="head_card_2">
        <img src="<?= basefolder() ?>/assets/card-3.png" alt="">
      </div>
      <div class="desc_card_2">
        <p>Pengenalan & Struktur Html</p>
        <p>Pengenalan & Struktur Html</p>
        <p>Pengenalan & Struktur Html</p>
        <p>Pengenalan & Struktur Html</p>
      </div>
      <div class="btn_card_2">
        <p>Lihat Modul</p>
      </div>
    </div>
    <div class="card_content_2">
      <div class="head_card_2">
        <img src="<?= basefolder() ?>/assets/card-4.png" alt="">
      </div>
      <div class="desc_card_2">
        <p>Pengenalan & Struktur Html</p>
        <p>Pengenalan & Struktur Html</p>
        <p>Pengenalan & Struktur Html</p>
        <p>Pengenalan & Struktur Html</p>
      </div>
      <div class="btn_card_2">
        <p>Lihat Modul</p>
      </div>
    </div> -->
  </div>
</div>

<div class="container-3">
  <div class="head-content-3">
    <h4>Kenapa belajar di LearnWeb?</h4>
    <p>
      Saatnya belajar web development dengan cara yang lebih mudah.LearnWeb
      menghadirkan materi terarah dan sederhana khusus untuk mahasiswa baru
      Teknik Informatika.
    </p>
  </div>
  <div class="main-content-3">
    <div class="left">
      <div class="box-left">
        <img src="assets/Frame 21.png" alt="" />
      </div>
    </div>
    <div class="right">
      <div class="frame_content">
        <div class="icon">
          <img src="assets/book2.png" alt="" />
        </div>
        <div class="text">
          <h4>Materi Terstruktur</h4>
          <p>
            Materi disusun secara terstruktur mulai dari dasar hingga mahir.
          </p>
        </div>
      </div>
      <div class="frame_content">
        <div class="icon">
          <img src="assets/fokus-tujuan.png" alt="" />
        </div>
        <div class="text">
          <h4>Materi Terstruktur</h4>
          <p>
            Materi disusun secara terstruktur mulai dari dasar hingga mahir.
          </p>
        </div>
      </div>
      <div class="frame_content">
        <div class="icon">
          <img src="assets/fleksibel.png" alt="" />
        </div>
        <div class="text">
          <h4>Materi Terstruktur</h4>
          <p>
            Materi disusun secara terstruktur mulai dari dasar hingga mahir.
          </p>
        </div>
      </div>
      <div class="frame_content">
        <div class="icon">
          <img src="assets/materi-ilustrasi.png" alt="" />
        </div>
        <div class="text">
          <h4>Materi Terstruktur</h4>
          <p>
            Materi disusun secara terstruktur mulai dari dasar hingga mahir.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<?php if (!isset($_COOKIE['login_token'])) { ?>
  <div class="container-4">
    <div class="head-content-4">
      <h4>Siap Jadi Web Developer dari dasar?</h4>
      <p>
        Mulai perjalananmu dengan materi terstruktur dan mudah dipahami.Gabung
        sekarang dan mulai belajar web development dari nol!
      </p>
    </div>
    <!-- <div class="btn-content-4">
      <span>Mulai Belajar</span>
    </div> -->
    <a href="<?= basefolder() ?>/course" class="btn_content_1">
      <span>Mulai Belajar</span>
    </a>
  </div>
<?php } ?>


<?php include __DIR__ . '/../components/footer.php'; ?>
<?php
$content = ob_get_clean();

include __DIR__ . '/../layouts/mainUser.php';
?>