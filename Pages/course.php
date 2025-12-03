<?php
// require_once __DIR__ . '../../helpers/url.php';
require_once __DIR__ . '/../controller/courseLearningPathController.php';
require_once __DIR__ . '/../middleware/guestMiddleware.php';
// $page_css = '<link rel="stylesheet" href="assets/css/learning-path.css" />';
$page_css  = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/course.css">';

ob_start();
?>
<style>
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
      color: #333;
   }
</style>
<div class="container-course">
   <h1>Course Page</h1>
   <p>Welcome to the course page. Here you can find various courses to enhance your skills.</p>
   <div class="grid grid-cols-12 gap-4">
      <?php foreach ($courseAll['data'] as $key => $course) {
      ?>
         <div class="col-span-6">
            <div class="content-modul">
               <div class="top-content">
                  <div class="img-left-modul">

                     <img src="<?= basefolder() ?>/uploads/admin/<?= $course->image ?>" alt="" srcset="" width="130px" height="100px" style="object-fit:cover;">
                  </div>
                  <div class="title-modul">
                     <!-- <span><i class="ri-check-line"></i>Selesai</span> -->
                     <p><?= $course->title ?></p>
                     <span class="jam"><i class="ri-time-line"></i>45 Jam</span>
                  </div>
               </div>
               <p class="desc-modul">
                  <?= $course->description ?>
               </p>
               <?php
               $progressBarData = progressBarData($course->course_id);
               ?>
            <div class="course-progress-wrapper">
               <div class="course-progress-bar">
                  <div class="course-progress-fill" style="width: <?= $progressBarData['percentage'] ?>%"></div>
               </div>
               <p class="course-progress-text">
                  Progress: <strong><?= $progressBarData['completed']  ?></strong> dari <strong><?= $progressBarData['total'] ?></strong> module
                  (<strong><?= $progressBarData['percentage'] ?>%</strong>)
               </p>
            </div>
               <form action="<?= basefolder() ?>/controller/courseLearningPathController.php" method="post">
                  <input type="hidden" name="action" value="createFirstProgress">
                  <input type="hidden" name="course_id" value="<?= $course->course_id ?>">
                  <div class="flex justify-end">
                     <button type="submit" class="main-btn">Mulai kerjakan</button>
                  </div>
               </form>
            </div>
         </div>
      <?php } ?>
   </div>

</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
<?php
$content = ob_get_clean();

include __DIR__ . '/../layouts/mainUser.php';
?>