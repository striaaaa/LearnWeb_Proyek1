<?php
require_once __DIR__ . '/../../../middleware/guestMiddleware.php';
require_once __DIR__ . '/../../../middleware/adminCheckMiddleware.php';
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

  .module-card.dragging {
    opacity: 0.5;
    background: #e0e0e0;
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

  .module-card.dragging {
    opacity: 0.5;
    background: #e0e0e0;
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
      <div class="col-span-3">uioui
        <p><?= htmlspecialchars($course->created_at ?? '-') ?></p>
      </div>
      <div class="col-span-1 flex justify-end items-center">
        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 12 24">
          <path fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" transform="rotate(-180 5.02 9.505)" />
        </svg>
      </div>
    </div>
    <div class="accordion-content">
      <form action="<?= basefolder() ?>/controller/moduleManajemenController.php" method="post">
        <input type="hidden" name="action" value="updateModuleOrder">
        <input type="hidden" name="orders_no" id="orders_no_all">
        <input type="hidden" name="course_id" value="<?= htmlspecialchars($course->course_id) ?>">
        <button class="save-order" type="submit" onclick="saveOrder(event,this, <?= htmlspecialchars($course->course_id) ?>)">Simpan Perubahan Urutan</button>
      </form>
      <div class="module-list" id="module-list-<?= htmlspecialchars($course->course_id) ?>">
        <?php foreach ($course->modules as $k => $module): ?>
          <!-- <?= htmlspecialchars($module->module_id) ?> -->
          <div class="grid grid-cols-12 module-card items-center" data-id="<?= htmlspecialchars($module->module_id) ?>" draggable="true">
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
              <button onclick='editModule(<?= json_encode($module) ?>)'>
                edit
              </button>
              <button onclick='deleteModule(<?= json_encode($module->module_id) ?>)'>
                hapus
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
</div>
</div>
<?php endforeach; ?>
</div>

<!-- MODULE EDIT -->
<div id="moduleModal" class="modal hidden">
  <form action="<?= basefolder() ?>/controller/moduleManajemenController.php" method="post">
    <div class="modal-content">
      <h3>Tambah / Edit Modul</h3>
      <label>Judul Modul</label>
      <input type="hidden" name="action" value="updateModuleTitle">
      <input type="hidden" name="module_id" id="moduleIdInput">
      <input type="text" id="moduleTitle" name="title" placeholder="Masukkan judul modul" />
      <div class="modal-btns">
        <button id="simpanModule" data-action="simpan" type="submit">Simpan</button>
        <button id="tutupModal" data-action="simpan" type="button">Batal</button>
      </div>
    </div>
  </form>
</div>
<div id="moduleModalDelete" class="modal hidden">
  <form action="<?= basefolder() ?>/controller/moduleManajemenController.php" method="post">
    form delete
    <input type="hidden" name="action" value="deleteModule">
    <input type="hidden" name="module_id" id="moduleIdInputDelete">
    <div class="modal-btns">
      <button id="simpanModule" data-action="hapus" type="submit">Hapus</button>
      <button id="tutupModal" data-action="hapus" type="button">Batal</button>
    </div>
  </form>
</div>

<script>
  const modulesDataInput = document.getElementById('modulesData');
  const modal = document.getElementById('moduleModal');
  const moduleModalDelete = document.getElementById('moduleModalDelete');
  // const saveBtn = document.getElementById('simpanModule');
  // const closeBtn = document.getElementById('tutupModal');
  const moduleTitleInput = document.getElementById('moduleTitle');
  const moduleIdInput = document.getElementById('moduleIdInput');
  const moduleIdInputDelete = document.getElementById('moduleIdInputDelete');
  const modalEdit = document.getElementById('moduleModal');
  const modalDelete = document.getElementById('moduleModalDelete');
  // const ordersNoInput = document.getElementById('orders_no_all');
  let orders_no = [];

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


  // --- DRAGGABLE MODULE CARDS ---
  let draggedItem = null;

  document.querySelectorAll('.module-list').forEach(list => {
    const saveButton = list.parentElement.querySelector('.save-order');

    list.addEventListener('dragstart', e => {
      draggedItem = e.target;
      e.target.classList.add('dragging');
      e.dataTransfer.effectAllowed = 'move';
      console.log(e);
    });

    list.addEventListener('dragend', e => {
      e.target.classList.remove('dragging');
      draggedItem = null;
    });

    list.addEventListener('dragover', e => {
      e.preventDefault();
      const afterElement = getDragAfterElement(list, e.clientY);
      if (afterElement == null) {
        list.appendChild(draggedItem);
      } else {
        list.insertBefore(draggedItem, afterElement);
      }
    });

    list.addEventListener('drop', () => {
      saveButton.style.display = 'inline-block';
    });
  });

  function getDragAfterElement(container, y) {
    const draggableElements = [...container.querySelectorAll('.module-card:not(.dragging)')];
    return draggableElements.reduce((closest, child) => {
      const box = child.getBoundingClientRect();
      const offset = y - box.top - box.height / 2;
      if (offset < 0 && offset > closest.offset) {
        return {
          offset: offset,
          element: child
        };
      } else {
        return closest;
      }
    }, {
      offset: Number.NEGATIVE_INFINITY

    }).element;

  }

  function saveOrder(e, button, courseId) {
    // e.preventDefault();
    const form = button.parentElement;
    const list = form.nextElementSibling;
    // const list = button.parentElement.parentElement.querySelector('.module-list');
    console.log('listbu', list);
    const order = Array.from(list.children).map(card => card.dataset.id);
    const ordersNoInput2 = form.querySelector('[name="orders_no"]');
    ordersNoInput2.value = JSON.stringify(order);
    // ordersNoInput.value = JSON.stringify(order);
    console.log(ordersNoInput2);

    console.log("Urutan baru untuk kursus ID " + courseId + ":", order);
    //  body: JSON.stringify({
    //           course_id: courseId,
    //           order: order
    //         })

  }
  // closeBtn.onclick = (e) => {
  //   const action = e.target.dataset.action;
  //   console.log(action);

  //   if(action==='simpan'){

  //     modal.classList.add('hidden');
  //   }else{
  //     console.log('els');
  //     moduleModalDelete.classList.add('hidden');
  //   }
  // }
  // saveBtn.onclick = (e) => {

  //   const action = e.target.dataset.action;
  //   if(action==='simpan'){

  //     modal.classList.add('hidden');
  //   }else{
  //     console.log('els');

  //     moduleModalDelete.classList.add('hidden');
  //   }
  // };


  // Tangkap SEMUA tombol yang punya atribut data-action
  document.querySelectorAll('button[data-action]').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const action = e.target.dataset.action;
      console.log('Aksi tombol:', action);

      // Tutup modal sesuai tombol
      if (action === 'simpan' || action === 'batal') {
        modalEdit.classList.add('hidden');
      } else if (action === 'hapus' || action === 'batal') {
        modalDelete.classList.add('hidden');
      }
    });
  });


  function editModule(moduleData) {
    modal.classList.remove('hidden');

    console.log(moduleData);
    moduleTitleInput.value = moduleData.title.trim()
    moduleIdInput.value = moduleData.module_id;

  }

  function deleteModule($moduleId) {
    moduleModalDelete.classList.remove('hidden');
    moduleIdInputDelete.value = $moduleId;

  }
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../../layouts/mainAdmin.php';
?>