<?php
// require_once __DIR__ . '../../helpers/url.php';
require_once __DIR__ . '/../controller/courseLearningPathController.php';
require_once __DIR__ . '/../helpers/imgcolor.php';
require_once __DIR__ . '/../middleware/guestMiddleware.php';
$page_css  = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/main-user.css">';

ob_start();
?>
<style>
   .container-course {
      /* max-width: 1200px;      */
      /* margin-left: 100px;
      margin-right: 100px; */
      margin-top: 0;
      margin-bottom: 0;
   }

   a {
      text-decoration: none;
   }

   .modul-success {
      width: 80%;
      height: 70vh;
      margin: auto;
      display: flex;
      justify-content: space-around;
      align-items: center;
      /* padding-top: 50px; */
   }

   .content-modul {
      /* width: 40%; */
      /* height: 35vh; */
      padding: 15px 30px;
      /* background: #ff6c6c; */
      /* border-radius: 16px;
  border: 1px solid #afafaf; */
      position: relative;
      overflow: hidden;
      /* background: rgba(20, 20, 30, 0.15); */
      /* base card */
      backdrop-filter: blur(18px);
      border-radius: 16px;
   }

   html:not(.dark) .content-modul {
      border: 2px solid #404141;
   }

   html.dark .content-modul {
      border: 2px solid var(--border);
   }



   /* Top right glow */
   .content-modul::before,
   .content-modul::after {
      content: "";
      position: absolute;
      width: 260px;
      height: 200px;
      filter: blur(60px);
      z-index: -1;
      pointer-events: none;
   }

   /* posisi berbeda */
   .content-modul::before {
      bottom: -70px;
      right: -70px;
      width: 400px;
      height: 200px;
   }

   .content-modul::after {
      top: -70px;
      left: -70px;
      width: 260px;
      height: 200px;
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
      color: var(--text);
      font-weight: 600;
   }

   .title-modul .jam {
      display: flex;
      gap: 10px;
      align-items: center;
      font-size: 16px;
      font-weight: 400;
      /* color: #4f4f4f; */
   }

   .content-modul .desc-modul {
      font-size: 16px;
      font-weight: 400;
      /* color: #4f4f4f; */
      line-height: 1.5;
      text-align: justify;
   }

   .line {
      height: 1px;
      background: #afafaf;
      margin: auto;
      margin-top: 30px;
   }

   .course-progress-wrapper {
      margin: 15px 0;
   }

   .course-progress-bar {
      width: 100%;
      background: #e6e6e6;
      border-radius: 8px;
      overflow: hidden;
      height: 8px;
      position: relative;
   }

   .course-progress-fill {
      background: #4CAF50;
      height: 100%;
      transition: width 0.4s ease;
   }

   .course-progress-text {
      margin-top: 6px;
      font-size: 14px;
   }
</style>
<div class="container-course mx-6 pt-6">
   <div class="header_content_2" style="text-align: start;">
      <p>Course Page</p>
   </div>
   <p class="mb-4">Welcome to the course page. Here you can find various courses to enhance your skills.</p>
   <div class="grid grid-cols-12 gap-4">
      <?php foreach ($courseAll['data'] as $key => $course):
         $imagePath = $_SERVER['DOCUMENT_ROOT'] . basefolder() . "/uploads/admin/{$course->image}";

      ?>

         <div class="col-span-12 lg:col-span-6 md:col-span-12">

            <div class="content-modul">



               <div class="top-content">
                  <div class="img-left-modul">
                     <img src="<?= basefolder() ?>/uploads/admin/<?= $course->image ?>"
                        width="130" height="100" style="object-fit:cover; border-radius: 8px;">
                  </div>
                  <div class="title-modul">
                     <p><?= $course->title ?></p>
                     <span class="jam"><i class="ri-time-line"></i>45 Jam</span>
                  </div>
               </div>

               <p class="desc-modul"><?= $course->description ?></p>
               <?php $progressBarData = progressBarData($course->course_id); ?>
               <div class="course-progress-wrapper">
                  <div class="course-progress-bar">
                     <div class="course-progress-fill"
                        style="width: <?= $progressBarData['percentage'] ?>%"></div>
                  </div>
                  <p class="course-progress-text">
                     Progress: <strong><?= $progressBarData['completed'] ?></strong>
                     dari <strong><?= $progressBarData['total'] ?></strong> module
                     (<strong><?= $progressBarData['percentage'] ?>%</strong>)
                  </p>
               </div>

               <form method="post" action="<?= basefolder() ?>/controller/courseLearningPathController.php">
                  <input type="hidden" name="action" value="createFirstProgress">
                  <input type="hidden" name="course_id" value="<?= $course->course_id ?>">
                  <div class="flex justify-end">
                     <button type="submit" class="main-btn-glow" style="width:fit-content;font-size:medium;">Mulai kerjakan</button>
                  </div>
               </form>

            </div>

         </div>

      <?php endforeach; ?>
   </div>



</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
<?php
$content = ob_get_clean();

include __DIR__ . '/../layouts/mainUser.php';
?>