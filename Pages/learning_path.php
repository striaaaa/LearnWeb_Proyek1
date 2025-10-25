<?php
// require_once __DIR__ . '../../helpers/url.php';
require_once __DIR__ . '/../controller/courseLearningPathController.php';
// $page_css = '<link rel="stylesheet" href="assets/css/learning-path.css" />';
$page_css  = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/learning-path.css">';
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


<div class="container-border">
  <h1>Kursus <?= $courseWithModulesResult->data->title ?></h1>
  <div class="materi">
    <?php foreach ($courseWithModulesResult->data->modules as $key => $course): ?>
      <div class="content">
        <div class="left-content">
          <div class="tahapan">
            <span>Langkah <?= $key + 1 ?></span>
          </div>
          <div class="head-content">
            <span><?= $course->title ?></span>
          </div>
        </div>

        <div class="line"></div>

        <div class="righ-content">
          <div class="header-right">
            <span>Pengenalan HTML</span>
          </div>

          <div class="list-modul">
            <ul>
              <?php if (!empty($course->contents)): ?> 
                  <li><?= htmlspecialchars($course->contents[0]->module_content) ?></li> 
              <?php else: ?>
                <li><em>Tidak ada konten tersedia</em></li>
              <?php endif; ?>
            </ul>
          </div>
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