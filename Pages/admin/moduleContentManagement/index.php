<?php
require_once __DIR__ . '/../../../controller/moduleManajemenController.php';
$page_css = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/admin/manajemen-penggguna.css" />';
ob_start();
?>

<style>
  .row-card-table-header {
    background: #ffffff;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
  }

  .row-card-table-course {
    margin-bottom: 10px;
  }

  .row-card-table-course-header {
    background: #ffffff;
    padding: 20px;
    border-radius: 10px;
    border-bottom-left-radius: 0px;
    border-bottom-right-radius: 0px;
    cursor: pointer;
    transition: 0.3s ease;
  }

  .row-card-table-course-header:hover {
    background: #fcfcfc;
  }

  .row-card-table-course-header:hover .accordion-content {
    background: #fcfcfc;
  }

  .accordion-content {
    transition: 0.3s;
    background: #ffffff;
    padding: 0px 20px;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    max-height: 0;
    overflow: hidden;
    transition: 0.3s ease;
  }

  .accordion-content.open {
    max-height: 1000px;
    padding-bottom: 20px;
  }

  .module-card {
    background: #f4f4f4;
    padding: 20px;
    border-radius: 5px;
    margin-bottom: 10px;
    cursor: grab;
    user-select: none;
    transition: 0.2s;
  }
 


  .arrow {
    transition: transform 0.3s;
  }

  .active .arrow {
    transform: rotate(90deg);
  }

  .module-list {
    margin-top: 20px;
  }
 

  .save-order {
    display: none;
  }
</style>

<div>
  <div class="btn-aksi">Tambah Kursus</div>

  <div class="row-card-table-header">
    <div class="grid grid-cols-12">
      <div class="col-span-1">
        <h4>No.</h4>
      </div>
      <div class="col-span-3">
        <h4>Judul</h4>
      </div>
      <div class="col-span-4">
        <h4>Deskripsi</h4>
      </div>
      <div class="col-span-3">
        <h4>Dibuat pada</h4>
      </div>
      <div class="col-span-1">
        <h4>Aksi</h4>
      </div>
    </div>
  </div>

  <?php foreach ($courseWithModulesResult['data'] as $index => $course): ?>
    <div class="row-card-table-course" ">
      <div class="" >
      <div class=" grid grid-cols-12 items-center row-card-table-course-header" onclick="toggleAccordion(this)">
      <div class="col-span-1">
        <p><?= $index + 1 ?>.</p>
      </div>
      <div class="col-span-3">
        <p><?= htmlspecialchars($course->title) ?></p>
      </div>
      <div class="col-span-4">
        <p><?= htmlspecialchars($course->description) ?></p>
      </div>
      <div class="col-span-3">
        <p><?= htmlspecialchars($course->created_at ?? '-') ?></p>
      </div>
      <div class="col-span-1 flex justify-end items-center">
        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 12 24">
          <path fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" transform="rotate(-180 5.02 9.505)" />
        </svg>
      </div>
    </div>
    <div class="accordion-content">
     
      <div class="module-list" id="module-list-<?= htmlspecialchars($course->course_id) ?>">
        <?php foreach ($course->modules as $k => $module): ?> 
          <div class="grid grid-cols-12 module-card items-center"  >
            <div class="col-span-1 flex items-center justify-between" style="padding-right: 40px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1">
                <path d="M3 3h.01M3 8h.01M3 13h.01M8 3h.01M8 8h.01M8 13h.01M13 3h.01M13 8h.01M13 13h.01" />
              </svg>
              <p><?= $k + 1 ?></p>
            </div>
            <div class="col-span-9">
              <p><?= htmlspecialchars($module->title) ?></p>
            </div>
            <div class="col-span-1 flex "> 
              <a href="<?= basefolder() ?>/admin/manajemen-modul-konten/<?= $module->module_id?>/tambah-konten" class="btn-edit" style="margin-right:5px;" onclick="editModule(<?= htmlspecialchars(json_encode($module), ENT_QUOTES, 'UTF-8') ?>)">
                tambah konten 
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
</div>
</div>
<?php endforeach; ?>
</div>
 

<script>       

  function toggleAccordion(header) {
    console.log(header.querySelector('.accordion-content'));

    const content = header.nextElementSibling;
    // const content = header.querySelector('.accordion-content');
    const isOpen = content.classList.contains('open');
    document.querySelectorAll('.accordion-content').forEach(c => c.classList.remove('open'));
    document.querySelectorAll('.row-card-table-course-header').forEach(h => h.classList.remove('active'));
    if (!isOpen) {
      content.classList.add('open');
      header.classList.add('active');
    }
  }
 

    
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../../layouts/mainAdmin.php';
?>