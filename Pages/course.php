<?php
// require_once __DIR__ . '../../helpers/url.php';
require_once __DIR__ . '/../controller/courseLearningPathController.php';
// $page_css = '<link rel="stylesheet" href="assets/css/learning-path.css" />';
$page_css  = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/course.css">';
ob_start();
?>
<div>
   <h1>Course Page</h1>
   <p>Welcome to the course page. Here you can find various courses to enhance your skills.</p>
   <?= var_dump($courseAll['data']); ?>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
<?php
$content = ob_get_clean();

include __DIR__ . '/../layouts/mainUser.php';
?>