<?php
// require_once __DIR__ . '../../helpers/url.php';
require_once __DIR__ . '/../controller/courseLearningPathController.php';
// $page_css = '<link rel="stylesheet" href="assets/css/learning-path.css" />';
global $params;
$page_css  = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/learning-path.css">';
$course_id = $params['courseId'] ?? null;
ob_start();
?>

<!-- <div class="path">
      <div class="path-1">
        <span>HTML</span>
      </div>
      <div class="path-1">
        <span>CSS</span>
      </div>
      <div class="path-1">
        <span>JavaScript</span>
      </div>
      <div class="path-1">
        <span>PHP</span>
      </div>
    </div> -->
<?php
// echo "<PRE>";
// var_dump($courseWithModulesResult['data'][0]->title);
// // echo json_encode($courseWithModulesResult['data'], JSON_PRETTY_PRINT);
// echo "</PRE>";
// 

?>
<?php
// echo '<pre>';
// print_r($courseWithModulesResult);
// echo '</pre>';
// exit;
?>

<style>
  .maateri-link{
    text-decoration: none;
  }
</style>
<div class="container-border">
  <h2>Kursus <?= var_dump($courseWithModulesResult->data) ?></h1>
  <h2>Kursus <?= $courseWithModulesResult->data->title ?></h1>
  <div class="materi">
    <?php foreach ($courseWithModulesResult->data->modules as $key => $course): ?>
      <a class="maateri-link" href="<?= basefolder() ?>/course/<?= $course_id ?>/detailModule/<?= $course->module_id ?>">
        <div class=" grid grid-cols-12">
          <div class="left-content col-span-5">
            <div class="tahapan">
              <span>Langkah <?= $key + 1 ?></span>
            </div>
            <div class="head-content">
              <!-- <?= var_dump($course) ?> -->
              <span><?= $course->title ?></span>
            </div>
          </div>
          <div class="col-span-1">
            <div class="line"></div>
          </div>
          
          <div class="left-content col-span-6">
            <div class="header-right">
              <span><?= $course->title ?></span> 
            </div>

            <div class="list-modul">
              <ul>
                <?php if (!empty($course->contents)): ?>

                  <?php
                  //                   echo "<pre>";
                  // var_dump(json_decode($course->contents[0]->module_content));
                  // echo "</pre>";
                  // exit;

                  $blocks = json_decode($course->contents[0]->module_content); 

                  $preview = "";

                  foreach ($blocks as $block) {
                    if(empty($block->type)){ 
                      $preview= "Data tidak ada";
                    }else{

                      if ($block->type === "paragraph") {
                        $text = $block->data->text;
                        $words = explode(" ", $text);
                        // var_dump($words);
                        $preview = implode(" ", array_slice($words, 0, 12)) . " ...";
                        // var_dump(array_slice($words, 0, 12));
                        break; 
                      }
                    }
                  }
                  ?>
 
                    <p><?= htmlspecialchars($preview) ?></p>
                

                <?php else: ?>
                  <li><em>Tidak ada konten tersedia</em></li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</div>

<?php include __DIR__ . '/../components/footer.php'; ?>
<?php
$content = ob_get_clean();

include __DIR__ . '/../layouts/mainUser.php';
?>