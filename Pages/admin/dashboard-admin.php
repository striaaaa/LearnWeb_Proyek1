<?php 
$page_css = '<link rel="stylesheet" href="assets/css/admin/manajemen-penggguna.css" />';
ob_start();
?>
 <div class="">
       asddasd
    </div>
<?php
$content = ob_get_clean();
include __DIR__ .'../../../layouts/mainAdmin.php';
?>