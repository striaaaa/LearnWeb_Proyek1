<?php
// require_once __DIR__ . '../../helpers/url.php';
require_once __DIR__ . '/../controller/courseLearningPathController.php';
require_once __DIR__ . '/../controller/homepageController.php';
// $page_css = '<link rel="stylesheet" href="assets/css/learning-path.css" />';
global $params;
$page_css  = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/main-user.css">';
$course_id = $params['courseId'] ?? null;
renderFlashAlert();
ob_start();
?>  

<style>
  .maateri-link {
    text-decoration: none;
  }
  .path {
  margin-top: 20px;
  margin-bottom: 20px;
  display: flex;
  justify-content: center;
  gap: 40px;
}

.path-1 {
  width: 20%;
  padding: 8px;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #d9d9d9;
  border-radius: 8px;
}

.container-border {
  border-bottom: 1px solid #d4d4d4;
  padding-bottom: 30px;
}

.materi {
  width: 80%;
  margin: auto;
  padding-top: 20px;
  display: flex;
  flex-direction: column;
  gap: 30px;
  /* background-color: aqua; */
}

.content {
  display: flex;
  justify-content: center;
  gap: 100px;
}

.left-content {
  width: 80%; 
  border: 1px solid #d4d4d4;
  border-radius: 10px;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.line {
  width: 1px;
  border-left: 2px solid #d4d4d4;
  height: 20vh;
}

.list-modul {
  padding: 5px 20px 5px 0px;
}
.maateri-link{ 
  height: 100%;
  width: 100%;
  border: none;
  background: none;
  font-size: 16px;
  text-align: start;
}

</style>
<div class="container-border">
  <?php if (empty($courseWithModulesResult->data->course_id)): ?>
    <div>
      <p class="header_content_2">
        Data tidak ada
      </p>
    </div>
  <?php else: ?>
    <?php

    
?>
    <p class="header_content_2" style="text-align: start;">Kursus <?= $courseWithModulesResult->data->title ?></p>
    <div class="materi">
      <?php
      $modulesss = $courseWithModulesResult->data->modules;
foreach ($modulesss as $key => $course): 
    $prev_module_id_input = $key > 0 ? $modulesss[$key - 1]->module_id : $course->module_id;
    // var_dump($prev_module_id_input);
?>
        <div class=" grid grid-cols-12">
          <div class="left-content col-span-5 p-4">
            <form action="<?= basefolder() ?>/controller/homepagecontroller.php" method="post" style="height: 100%;">
              <input type="hidden" name="course_id" value="<?= $course->course_id ?>">
              <input type="hidden" name="module_id" value="<?= $course->module_id  ?>">
                <input type="hidden" name="prev_module_id" value="<?=$prev_module_id_input ?>">
              <input type="hidden" name="order_no" value="<?= $course->order_no ?>">
              <input type="hidden" name="action" value="getUserProgresCheck">
              <button class="flex items-start maateri-link justify-between " type="submit">
                <div class=" ">
                  <div class="tahapan">
                    <p>

                      Langkah <?= $key + 1 ?>&nbsp; 
                    </p>
                  </div>
                  <div class="head-content mb-4">
                    <h3 style="font-weight: 500;"><?= $course->title ?></h3>
                  </div>
                  <h4 style="font-weight: 500;"><i class="ri-time-fill"></i> &nbsp;<?= $course->learning_time ?> Menit</h4>
                  <h4 style="font-weight: 500;"><i class="ri-time-fill"></i> &nbsp;<?= $course->count_content ?> Sesi</h4>
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