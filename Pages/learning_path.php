<?php
// require_once __DIR__ . '../../helpers/url.php';
require_once __DIR__ . '/../controller/courseLearningPathController.php';
// $page_css = '<link rel="stylesheet" href="assets/css/learning-path.css" />';
$page_css  = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/learning-path.css">';
ob_start();
?> 
    <div class="path">
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
    </div>
    <?php
    echo "<pre>";
    var_dump($courseWithModulesResult['data']);
    echo "</pre>";
    ?>
    <div class="container-border">
      <div class="materi">
        <?php
        foreach ($courseWithModulesResult['data'] as $key=>$course) {
        ?>
        <div class="content">
          <div class="left-content">
            <div class="tahapan">
              <span>Langkah <?=$key?></span>
            </div>
            <div class="head-content"><span><?=$course['title'] ?></span></div> 
          </div>
          <div class="line"></div>
          <div class="righ-content">
            <div class="header-right">
              <span>Pengenalan HTML</span>
            </div>
            <div class="list-modul">
              <ul>
                <li><?=$course['module_content']?>?</li> 
              </ul>
            </div>
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
