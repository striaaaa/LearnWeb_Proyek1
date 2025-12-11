<?php
require_once __DIR__ . '/../controller/homepageController.php';
$page_css  = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/main-user.css">';
ob_start();
?>
<style>
  .container-atassindex {
    position: relative;
    width: 100%;
}

.container-atassindex img.bg-base {
    width: 100%;
    height: auto;
    border-radius: 20px;
    display: block;
}

  .iconambang {
    position: absolute;
    cursor: grab;
    user-select: none;
    transition: transform 0.4s ease;
    user-select: none;
    -webkit-user-drag: none;
    /* Chrome, Safari */
    -khtml-user-drag: none;
    -moz-user-drag: none;
    -o-user-drag: none;
    user-drag: none;
    
  transform: translate(-50%, -50%);
  } 
  
/* posisi awal dalam % */
.iconambang[data-index="1"] { top: 5%;  left: 20%;  width: 15%; }
.iconambang[data-index="2"] { top: 40%; left: 30%;  width: 15%; }
.iconambang[data-index="3"] { top: 38%; left: 60%;  width: 15%; }
.iconambang[data-index="4"] { top: 32%; left: 10%;  width: 15%; }
.iconambang[data-index="5"] { top: 12%; left: 58%;  width: 15%; }

/* =====================
   Float Animation
===================== */
@keyframes float {
  0%   { transform: translate(-50%, -50%) translateY(0px) rotate(0deg); }
  50%  { transform: translate(-50%, -50%) translateY(-10px) rotate(2deg); }
  100% { transform: translate(-50%, -50%) translateY(0px) rotate(0deg); }
}


  .floating {
    animation: float 4s ease-in-out infinite;
  }
</style>
<div class="container-1 grid grid-cols-12 pt-8">
  <div class="col-span-12 order-2 lg:order-1  lg:col-span-6  p-4 lg:p-0 md:p-0">
    <div class="header_content_1">
      <p>Belajar <span class="gradient-teks ">
          Web Development
        </span>
        Dasar dengan Mudah</p>
    </div>
    <div class="sub_header_content_1">
      <p>Materi terstruktur untuk mahasiswa baru Teknik Informatika</p>
    </div>

    <button class="main-btn-glow mt-4 " data-link="<?= basefolder() ?>/course">
      Belajar Sekarang
    </button>
  </div>
  <div class="col-span-12 order-1 lg:order-2   lg:col-span-6 " style="position: relative;"> 
   <div class="container-atassindex" id="area">
    <img class="bg-base" src="<?= basefolder() ?>/assets/image22.png" alt="" />

    <img src="<?= basefolder() ?>/assets/img/icon/docedit.png" class="iconambang floating" data-index="1">
    <img src="<?= basefolder() ?>/assets/img/icon/torphy.png" class="iconambang floating" data-index="2">
    <img src="<?= basefolder() ?>/assets/img/icon/cmdd.png" class="iconambang floating" data-index="3">
    <img src="<?= basefolder() ?>/assets/img/icon/clipboard.png" class="iconambang floating" data-index="4">
    <img src="<?= basefolder() ?>/assets/img/icon/Laptop.png" class="iconambang floating" data-index="5">
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
            <!-- <?= var_dump($module) ?>
            <?php if (empty((array)$module->title ?? '')): ?> -->
            <!-- <div>modul tidak lengkap</div> -->
            <!-- <?php else: ?>
                <?php endif; ?> -->
            <p><?= $module->title ?? 'module tidak ada' ?></p>
          <?php endforeach; ?>
        </div>
        <button data-link="<?= basefolder() ?>/course" style="text-decoration:none;width:fit-content;font-size:medium;" class="main-btn-glow">
          Lihat Modul
        </button>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="container-card-2">
  </div>
</div>
<div class="container-3 grid grid-cols-12  ">
  <div class="col-span-12 lg:col-start-3 lg:col-span-8 md:col-start-3 md:col-span-8 head-content-3   ">
    <h4 class="mb-4">Kenapa belajar di LearnWeb?</h4>
    <p>
      Saatnya belajar web development dengan cara yang lebih mudah.LearnWeb
      menghadirkan materi terarah dan sederhana khusus untuk mahasiswa baru
      Teknik Informatika.
    </p>
  </div>
  <div class="main-content-3 col-span-12 grid grid-cols-12 px-6">
    <div class="left col-span-12 lg:col-span-4 md:col-span-12">
      <div class="box-left">
        <img src="assets/Frame 21.png" alt="" />
      </div>
    </div>
    <div class="right col-span-12 lg:col-span-8 md:col-span-12">
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
    <button data-link="<?= basefolder() ?>/course" class="btn_content_1">
      Mulai Belajar
    </button>
  </div>
<?php } ?>
<script>
  const container = document.getElementById("area");
  const icons = document.querySelectorAll(".iconambang");

  icons.forEach(icon => {
    icon.addEventListener("dragstart", e => e.preventDefault()); // stop ghost image

    let isDragging = false;
    let offsetX = 0,
      offsetY = 0;

    const startX = icon.offsetLeft;
    const startY = icon.offsetTop;

    icon.addEventListener("mousedown", startDrag);
    icon.addEventListener("touchstart", startDrag);

    function startDrag(e) {
      e.preventDefault();
      isDragging = true;
      icon.classList.remove("floating");
      icon.style.transition = "none";
      icon.style.cursor = "grabbing";

      const rect = container.getBoundingClientRect();
      const clientX = e.touches ? e.touches[0].clientX : e.clientX;
      const clientY = e.touches ? e.touches[0].clientY : e.clientY;

      offsetX = clientX - (rect.left + icon.offsetLeft);
      offsetY = clientY - (rect.top + icon.offsetTop);

      document.addEventListener("mousemove", onDrag);
      document.addEventListener("touchmove", onDrag, {
        passive: false
      });
      document.addEventListener("mouseup", endDrag);
      document.addEventListener("touchend", endDrag);
    }

    function onDrag(e) {
      if (!isDragging) return;
      e.preventDefault(); // stop scroll

      const rect = container.getBoundingClientRect();
      const clientX = e.touches ? e.touches[0].clientX : e.clientX;
      const clientY = e.touches ? e.touches[0].clientY : e.clientY;

      let x = clientX - rect.left - offsetX;
      let y = clientY - rect.top - offsetY;

      // batasi supaya tidak keluar container
      x = Math.max(0, Math.min(x, rect.width - icon.offsetWidth));
      y = Math.max(0, Math.min(y, rect.height - icon.offsetHeight));

      icon.style.left = x + "px";
      icon.style.top = y + "px";
    }

    function endDrag() {
      if (!isDragging) return;
      isDragging = false;
      icon.style.cursor = "grab";

      // icon.style.transition = "top 0.6s cubic-bezier(0.68, -0.55, 0.27, 1.55), left 0.6s cubic-bezier(0.68, -0.55, 0.27, 1.55)";
      icon.style.transition = "top 0.8s cubic-bezier(0.22, 1, 0.36, 1), left 0.8s cubic-bezier(0.22, 1, 0.36, 1)";
      // icon.style.transition = "top 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94), left 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94)";
      icon.style.left = startX + "px";
      icon.style.top = startY + "px";

      setTimeout(() => {
        icon.classList.add("floating");
      }, 500);

      document.removeEventListener("mousemove", onDrag);
      document.removeEventListener("touchmove", onDrag);
      document.removeEventListener("mouseup", endDrag);
      document.removeEventListener("touchend", endDrag);
    }
  });
</script>
<?php include __DIR__ . '/../components/footer.php'; ?>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/mainUser.php';
?>