<?php
// require_once __DIR__ . '../../helpers/url.php';
require_once __DIR__ . '/../controller/courseLearningPathController.php';
require_once __DIR__ . '/../controller/homepageController.php';
// $page_css = '<link rel="stylesheet" href="assets/css/learning-path.css" />';
global $params;
$page_css  = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/learning-path.css">';
$course_id = $params['courseId'] ?? null;
renderFlashAlert();
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
  .maateri-link {
    text-decoration: none;
  }
</style>
<div class="container-border">
  <?php if (empty($courseWithModulesResult->data->course_id)): ?>
    <div>
      Data tidak ada
    </div>
  <?php else: ?>
    <h2>Kursus <?= $courseWithModulesResult->data->title ?></h2>
    <div class="materi">
      <?php foreach ($courseWithModulesResult->data->modules as $key => $course): ?>
        <div class=" grid grid-cols-12">
          <div class="left-content col-span-5">
            <form action="<?= basefolder() ?>/controller/homepagecontroller.php" method="post" style="height: 100%;">
              <input type="hidden" name="course_id" value="<?= $course->course_id ?>">
              <input type="hidden" name="module_id" value="<?= $course->module_id  ?>">
              <input type="hidden" name="order_no" value="<?= $course->order_no ?>">
              <input type="hidden" name="action" value="getUserProgresCheck">
              <button class="flex items-start maateri-link justify-between " type="submit">
                <div class="flex ">
                  <div class="tahapan">
                    <span>Langkah <?= $key + 1 ?>&nbsp; </span>
                  </div>
                  <div class="head-content">
                    <span><?= $course->title ?></span>
                  </div>
                </div>
                <p><?= $course->progress_status ?></p>
              </button>
            </form>
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
                    if (empty($block->type)) {
                      $preview = "Data tidak ada";
                    } else {

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
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/../components/footer.php'; ?>
<?php
$content = ob_get_clean();

include __DIR__ . '/../layouts/mainUser.php';
?>