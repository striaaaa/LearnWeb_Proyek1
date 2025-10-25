<?php

require_once __DIR__ . '/../../../controller/courseManajemenController.php';
$page_css = '<link rel="stylesheet" href="'.basefolder().'/assets/css/admin/manajemen-penggguna.css" />';
ob_start();
?>
  <div class=""> 
      <a href="<?=basefolder().'/admin/manajemen-kursus/tambah-kursus'?>" class="btn-aksi">Tambah Kursus</a>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Foto</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <!-- <?=var_dump($getCourses)?> -->
          <?php foreach ($getCourses['data'] as $key => $course) { ?>
          <tr>
            <td>1</td>
            <td><?=$course->title?></td>
            <td>
              <span><?=$course->description?></span>
            </td>
            <td>
              <?php if (!empty($course->image)) {?>
              <img src="<?=basefolder()?>/uploads/admin/<?=$course->image?>" alt="" srcset="">
              <?php } else{ ?>
              <span>Tidak ada gambar</span>
              <?php } ?>
            </td>
            <td class="aktif">
              <span>Aktif</span>
              <span>Aktif</span>
            </td>
          </tr>
           <?php }?>
        </tbody>
      </table>
    </div>
 
<?php
$content = ob_get_clean();
include __DIR__ . '/../../../layouts/mainAdmin.php';
?>