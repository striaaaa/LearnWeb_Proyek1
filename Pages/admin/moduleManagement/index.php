<?php

require_once __DIR__ . '/../../../controller/moduleManajemenController.php';
$page_css = '<link rel="stylesheet" href="'.basefolder().'/assets/css/admin/manajemen-penggguna.css" />';
ob_start();
?>

<div>
  <div class="btn-aksi">Tambah Kursus</div>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Course</th>
        <th>Modul</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
        <!-- <?=var_dump($courseWithModulesResult['data'])?> -->
      <?php foreach ($courseWithModulesResult['data'] as $course): ?>
  <tr>
    <td><?= htmlspecialchars($course->title) ?></td>
    <td>
      <ul>
        <?php foreach ($course->modules as $module): ?>
          <li><?= htmlspecialchars($module->title) ?></li>
        <?php endforeach; ?>
      </ul>
    </td>
    <td class="aktif">
      <span>Tambah Modul</span>
    </td>
  </tr>
<?php endforeach; ?>

    </tbody>
  </table>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../../layouts/mainAdmin.php';
?>
