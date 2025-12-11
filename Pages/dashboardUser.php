<?php
require_once __DIR__ . '/../controller/dashboardController.php';
require_once __DIR__ . '/../middleware/guestMiddleware.php'; 

$page_css  = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/main-user.css">';
ob_start();
?>
<style>
  .container-profile {
  display: flex;
  /* justify-content: center; */
  /* align-items: center; */
  gap: 50px;
  padding: 50px;
  background: #3d3d3d;
  color: white;
}

.img-radius {
  width: 250px;
  height: 250px;
  background: #595959;
  border-radius: 50%;
}

.img-radius img {
  border-radius: 50%;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.detail-profile {
  display: flex;
  flex-direction: column;
  padding-top: 20px;
  gap: 10px;
}

.detail-profile h1 {
  font-size: 36px;
  font-weight: 600;
  margin-bottom: 10px;
  letter-spacing: 1px;
}
.detail-profile span {
  font-size: 20px;
  font-weight: 400;
  color: #d4d4d4;
}
.detail-profile i {
  font-size: 20px;
  font-weight: 400;
}
.bergabung {
  display: flex;
  align-items: center;
  gap: 10px;
}

.modul-success {
  width: 80%;
  height: 100%;
  /* height: 70vh; */
  margin: auto; 
  padding: 50px 0px;

}

.content-modul {
  /* width: 100%; */
  height: 100%;
  padding: 15px 30px;
  /* background: #ff6c6c; */
  border-radius: 16px;
  border: 1px solid #afafaf;
}

.top-content {
  display: flex;
  /* justify-content: space-between; */
  align-items: center;
  gap: 20px;
  margin-bottom: 20px;
}

.img-left-modul {
  width: 80px;
  height: 80px;
  background: #d9d9d9;
  border-radius: 12px;
  overflow: hidden;
}

.title-modul {
  display: flex;
  flex-direction: column;
  gap: 5px;
  font-size: 16px;
  font-weight: 600;
}

.title-modul span {
  color: #4db029;
  display: flex;
  gap: 10px;
  align-items: center;
}
.title-modul p {
  font-size: 20px;
  font-weight: 600;
}
.title-modul .jam {
  display: flex;
  gap: 10px;
  align-items: center;
  font-size: 16px;
  font-weight: 400;
  color: #4f4f4f;
}

.content-modul .desc-modul {
  font-size: 16px;
  font-weight: 400;
  color: #4f4f4f;
  line-height: 1.5;
  text-align: justify;
}

.btn-download {
  width: 150px;
  height: 40px;
  background: #3d3d3d;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 8px;
  cursor: pointer;
  margin-top: 20px;
}

.btn-download:hover {
  background: #595959;
  transition: 0.3s;
}

.line {
  height: 1px;
  background: #afafaf;
  margin: auto;
  margin-top: 30px;
}
.btn_edit {
  /* width: 30%; */
  padding: 15px;
  display: flex;
  justify-content: center;
  align-items: center;
  background: #676767;
  border-radius: 8px;
  margin-top: 20px;
  cursor: pointer;
}

</style>
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
       <div class="col-span-12 lg:col-span-6 md:col-span-12">
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