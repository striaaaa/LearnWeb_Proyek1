<?php
require_once __DIR__ . '/../controller/dashboardController.php';
require_once __DIR__ . '/../middleware/guestMiddleware.php';
// $page_css = '<link rel="stylesheet" href="assets/css/dashboard.css" />';

$page_css  = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/dashboard.css">';
ob_start();
?>
<div class="container-profile">
  <div class="img-radius">
    <img src="<?= $userLogin->image ? basefolder() . '/uploads/user/profil/' . $userLogin->image : 'https://image.idntimes.com/post/20230220/888355494-47236b76652f2e55025900cd98ccd09e-0759d9cc026a3c781b24c228b3d42224.jpg' ?>" alt="user" />
  </div>
  <div class="detail-profile">
    <h1><?= $userLogin->name ?></h1>
    <div class="bergabung">
      <i class="ri-calendar-2-fill"></i>
      <span>Bergabung sejak <?= $userLogin->created_at ?></span>
    </div>
    <div class="bergabung">
      <i class="ri-map-pin-2-fill"></i>
      <span><?= $userLogin->alamat ?></span>
    </div>
    <div class="btn_edit">
      <a href="<?= basefolder() ?>/dashboard/edit-profile" style="text-decoration: none"><span>Edit Profile</span></a>
    </div>
  </div>
</div>

<div class="modul-success grid grid-cols-12 gap-4"> 

  <?php 
  
  $rawGetCourseCompletedUser = $getCourseCompletedUser["data"] ?? [];
  // var_dump(empty((array)$rawGetCourseCompletedUser));
  if (empty((array)$rawGetCourseCompletedUser)):?>
    <div class="col-span-12">
      <p class="text-center ">
        Belum ada course yang selesai.
      </p>
    </div>
  <?php else: ?>
    <?php 
     if (!is_array($rawGetCourseCompletedUser)) {
      $rawGetCourseCompletedUser = [$rawGetCourseCompletedUser];
    }
    foreach ($rawGetCourseCompletedUser as $course): ?>
      <div class="col-span-6">
        <div class="content-modul">
          <div class="top-content">
            <div class="img-left-modul">
              <img src="<?= basefolder() ?>/uploads/admin/<?= $course->image ?>"
                alt="<?= $course->title ?>"
                width="130px" height="100px"
                style="object-fit:cover;" />
            </div>
            <div class="title-modul">
              <span> 
                <?= $course->status_course ?>
              </span>
              <p><?= $course->title ?></p>
              <span class="jam">
                <i class="ri-time-line"></i>45 Jam
              </span>
            </div>
          </div>

          <p class="desc-modul"><?= $course->description ?></p>
          <form action="<?=basefolder()?>/controller/dashboardController.php?action=createMaterPdfGetData" method="POST">
            <input type="hidden" name="action" value="createMaterPdfGetData">
            <input type="hidden" name="course_id" value="<?= $course->course_id ?>">
            <button class="btn-download" type="submit">Unduh Materi</button>
          </form>
          <form action="<?=basefolder()?>/controller/dashboardController.php?action=createCertificate" method="POST">
            <input type="hidden" name="action" value="createCertificate">
            <input type="hidden" name="course_title" value="<?= $course->title ?>">
            <button class="btn-download" type="submit">Unduh sertifikat</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>


<div class="line"></div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/mainUser.php';
?>