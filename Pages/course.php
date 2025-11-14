<?php
// require_once __DIR__ . '../../helpers/url.php';
require_once __DIR__ . '/../controller/courseLearningPathController.php';
require_once __DIR__. '/../middleware/guestMiddleware.php';
// $page_css = '<link rel="stylesheet" href="assets/css/learning-path.css" />';
$page_css  = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/course.css">';
ob_start();
?>
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
           
            <img src="<?= basefolder() ?>/uploads/admin/<?= $course->image ?>" alt="" srcset="" width="130px" height="100px" style="object-fit:cover;" >
          </div>
          <div class="title-modul">
             <span><i class="ri-check-line"></i>Selesai</span>
            <p><?=$course->title?></p>
            <span class="jam"><i class="ri-time-line"></i>45 Jam</span>
         </div>
        </div>
        <p class="desc-modul">
           <?=$course->description?>
         </p>
         <a href="<?=basefolder()?>/course/<?=$course->course_id?>" class="btn-download">Mulai kerjakan</a>
      </div>
   </div>
      <?php }?>
   </div>
      
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
<?php
$content = ob_get_clean();

include __DIR__ . '/../layouts/mainUser.php';
?>