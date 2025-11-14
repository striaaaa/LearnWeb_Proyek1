<?php

$page_css = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/admin/manajemen-penggguna.css" />';
$page_css2 = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/admin/global-admin.css" />';
ob_start();
?>
<div class="">
  <form  action="<?= basefolder() ?>/controller/courseManajemenController.php?action=store"
    method="POST"
    enctype="multipart/form-data"
    id="formKursus">
    <!-- <div class="btn-aksi">Tambah Kursus</div> -->
    <div class="grid grid-cols-12 justify-between">
      <div class="col-span-7">
        <div class="left-card  flex flex-col justify-between h-full">
          <div >
            <h3 class="right-card-h3">Tambah Kursus</h3>
            <label for="title">Judul</label>
            <input type="text" id="courseTitle" name="title" />
            <label for="description" >Deskripsi</label>
            <textarea name="description" id="courseDesc" cols="30" rows="10"></textarea>
            <label for="">Foto</label>
            <input type="file" id="courseImage" style="background-color: #ffffff;"  name="courseImage"/>
          </div>
          <button id="simpanKursus" type="submit" class="btn-aksi-default">Simpan</button>
        </div>
      </div>
      <div class="col-span-1"></div>
      <div class="col-span-4 right-card">
        <div class="card-content-tambah">

          <h3 class="right-card-h3">List Modul</h3>
          <div class="frame-list-modul" id="modulesContainer">
            <!-- <div class="list-modul">
              <span>JudulModul</span>
              <p>asodknadwakdladnaowdnawoiawk</p>
            </div>  -->
          </div>
          <button id="tbhModul" type="button" class="btn-aksi-default" style="width: 100%;">
            Tambah modul
          </button>
        </div>
      </div>
    </div>
    <div id="moduleModal" class="modal hidden">
      <div class="modal-content">
        <h3>Tambah / Edit Modul</h3>
        <label>Judul Modul</label>
        <input type="text" id="moduleTitle" placeholder="Masukkan judul modul" />
        <input type="hidden" id="moduleIndex" />
        <div class="modal-btns">
          <button id="simpanModule" type="button" class="btn-confirm-edit">Simpan</button>
          <button id="tutupModal" type="button" class="btn-close">Batal</button>
        </div>
      </div>
    </div>
    <input type="hidden" name="modulesData" id="modulesData" />
  </form>
  <!-- <button onclick="  modulesDataInput.value = JSON.stringify(modules); console.log(modulesDataInput.value);">
    tes
  </button> -->
</div>

<script>
  const container = document.getElementById('modulesContainer');
  const addBtn = document.getElementById('tbhModul');
  const modal = document.getElementById('moduleModal');
  const titleInput = document.getElementById('moduleTitle');
  const indexInput = document.getElementById('moduleIndex');
  const saveBtn = document.getElementById('simpanModule');
  const closeBtn = document.getElementById('tutupModal');
  const modulesDataInput = document.getElementById('modulesData');
  const formKursus = document.getElementById("formKursus");
  let modules = [];
formKursus.addEventListener("keydown", function (event) {
  if (event.key === "Enter") {
    event.preventDefault();
  }
});

  function renderModules() {
    container.innerHTML = '';
    modules.forEach((m, i) => {
      const div = document.createElement('div');
      div.className = 'list-modul';
      div.draggable = true;
      div.innerHTML = `<span>${m.title}</span>`;
      div.addEventListener('click', () => openModal(i));
      container.appendChild(div);
    });
    attachDragEvents();
  }

  function attachDragEvents() {
    const items = container.querySelectorAll('.list-modul');
    items.forEach(item => {
      item.addEventListener('dragstart', () => item.classList.add('dragging'));
      item.addEventListener('dragend', () => {
        item.classList.remove('dragging');
        updateOrder();
      });
    });
  }

  container.addEventListener('dragover', e => {
    e.preventDefault();
    const draggingItem = document.querySelector('.dragging');
    const afterElement = getDragAfterElement(container, e.clientY);
    if (afterElement == null) container.appendChild(draggingItem);
    else container.insertBefore(draggingItem, afterElement);
  });

  function getDragAfterElement(container, y) {
    const els = [...container.querySelectorAll('.list-modul:not(.dragging)')];
    return els.reduce((closest, child) => {
      const box = child.getBoundingClientRect();
      const offset = y - box.top - box.height / 2;
      if (offset < 0 && offset > closest.offset) return {
        offset,
        element: child
      };
      else return closest;
    }, {
      offset: Number.NEGATIVE_INFINITY
    }).element;
  }

  function updateOrder() {
    const list = [...container.querySelectorAll('.list-modul span')];
    modules = list.map((el, index) => ({
      title: el.textContent,
      order_no: index + 1
    }));
  }
 
  function openModal(index = null) {
    modal.classList.remove('hidden');
    if (index !== null) {
      titleInput.value = modules[index].title;
      indexInput.value = index;
    } else {
      titleInput.value = '';
      indexInput.value = '';
    }
  }

  closeBtn.onclick = () => modal.classList.add('hidden');

  saveBtn.onclick = () => {
    const title = titleInput.value.trim();
    if (!title) return alert('Judul modul wajib diisi!');
    const idx = indexInput.value;
    if (idx === '') {
      modules.push({
        title,
        order_no: modules.length + 1
      });
    } else {
      modules[idx].title = title;
    }
    modal.classList.add('hidden');
    renderModules();
  };

  addBtn.onclick = () => openModal();

  document.getElementById('simpanKursus').addEventListener('click', () => {
    const title = document.getElementById('courseTitle').value.trim();
    const desc = document.getElementById('courseDesc').value.trim();
    const image = document.getElementById('courseImage').files[0];

    if (!title || !desc) return alert('Lengkapi judul dan deskripsi kursus!');
 modulesDataInput.value = JSON.stringify(modules);
    // const formData = new FormData();
    // formData.append('title', title);
    // formData.append('description', desc);
    // if (image) formData.append('image', image);

    // formData.append('modules', JSON.stringify(modules));


    // fetch('simpan_kursus.php', {
    //   method: 'POST',
    //   body: formData
    // })
    // .then(res => res.json())
    // .then(data => {
    //   alert(data.message);
    //   console.log(data);
    // });
  });

  document.getElementById('formKursus').addEventListener('submit', e => {
    const modules = Array.from(container.querySelectorAll('.list-modul input')).map((input, i) => ({
      title: input.value,
      order_no: i + 1
    }));
   
  });
</script>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../../layouts/mainAdmin.php';
?>