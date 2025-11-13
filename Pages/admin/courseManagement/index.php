<?php
require_once __DIR__ . '/../../../controller/courseManajemenController.php';
$page_css = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/admin/manajemen-pengguna.css" />';
ob_start();
?>

<style>

</style>

<div class="table-controls">
  <div class="search-wrapper" role="search" aria-label="Cari kursus">
    <svg class="search-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg">
      <path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
      <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
    <input type="text" id="searchCourse" class="search-input" placeholder="Cari kursus...">
  </div>

  <select id="limitSelect" class="limit-select">
    <option value="5">5</option>
    <option value="10" selected>10</option>
    <option value="25">25</option>
    <option value="50">50</option>
  </select>
</div>

<a href="<?= basefolder() ?>/admin/manajemen-kursus/tambah-kursus" class="btn-aksi">Tambah Kursus</a>

<div id="courseList">
  <div class="row-card-table-header">
    <div class="grid grid-cols-12">
      <div class="col-span-1">No.</div>
      <div class="col-span-3">Judul</div>
      <div class="col-span-4">Deskripsi</div>
      <div class="col-span-3">Dibuat pada</div>
      <div class="col-span-1">Aksi</div>
    </div>
  </div>

  <?php foreach ($getCourses['data'] as $index => $course): ?>
    <div class="row-card-table-course">
     <div class="grid grid-cols-12 items-center row-card-table-course-header">
  <div class="col-span-1 flex justify-start items-center">
    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 12 24"
      onclick="toggleAccordion(this.parentElement.parentElement)">
      <path fill="currentColor"
        d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"
        transform="rotate(-180 5.02 9.505)" />
    </svg>
    &nbsp;
    &nbsp;
    <span class="ml-2"><?= $index + 1 ?>.</span>
  </div>
  <div class="col-span-3"><?= htmlspecialchars($course->title) ?></div>
  <div class="col-span-4"><?= htmlspecialchars($course->description) ?></div>
  <div class="col-span-3"><?= htmlspecialchars($course->created_at ?? '-') ?></div>
  <div class="col-span-1 flex justify-end gap-2 items-center">
    <button 
  onclick='openEditModal(<?= json_encode($course, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)' 
  class="btn-edit">
  Edit
</button>

    <button onclick="openDeleteModal(<?= json_encode($course->course_id) ?>)" class="btn-delete">Hapus</button>
  </div>
</div>


      <div class="accordion-content">
        <div class="module-list">
          <?php if (!empty($course->modules)): ?>
            <?php foreach ($course->modules as $k => $module): ?>
              <div class="grid grid-cols-12 module-card items-center">
                <div class="col-span-1"><?= $k + 1 ?></div>
                <div class="col-span-9"><?= htmlspecialchars($module->title) ?></div>
                <div class="col-span-2 flex justify-end">
                  <a href="#" class="btn-edit">Lihat detail</a>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p style="padding: 10px;">Belum ada modul untuk kursus ini.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div> 
<div id="modalEdit" class="modal hidden">
  <div class="modal-content">
    <h3>Edit Kursus</h3>

    <form id="formEdit" action="<?= basefolder() ?>/controller/courseManajemenController.php?action=updateCourse" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="course_id" id="editId">
      <input type="hidden" name="oldImage" id="editOldImage">

      <div class="form-group">
        <label for="editTitle">Judul Kursus</label>
        <input type="text" id="editTitle" name="title" required>
      </div>

      <div class="form-group">
        <label for="editDescription">Deskripsi</label>
        <textarea id="editDescription" name="description" rows="3" required></textarea>
      </div>

      <div class="form-group">
        <label for="editImage">Gambar (opsional)</label>
        <input type="file" id="editImage" name="courseImage">
      </div>

      <div class="modal-btns">
        <button type="button" id="tutupEdit" class="btn-close">Tutup</button>
        <button type="submit" class="btn-confirm">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
 
<div id="modalDelete" class="modal hidden">
  <div class="modal-content">
    <h3>Hapus Kursus</h3>
    <p>Apakah kamu yakin ingin menghapus kursus ini?</p>

    <form id="formDelete" action="<?= basefolder() ?>/controller/courseManajemenController.php?action=deleteCourse" method="POST">
       <input type="hidden" name="course_id" id="deleteCourseId">

      <div class="modal-btns">
        <button type="button" id="tutupDelete" class="btn-close">Batal</button>
        <button type="submit" id="konfirmasiDelete" class="btn-confirm">Hapus</button>
      </div>
    </form>
  </div>
</div>

<div class="pagination" id="pagination"></div>

<script>
  function toggleAccordion(header) {
    const row = header.closest('.row-card-table-course');
    const content = row.querySelector('.accordion-content');
    const isOpen = content.classList.contains('open');

    // Tutup semua accordion lain
    document.querySelectorAll('.accordion-content').forEach(c => c.classList.remove('open'));
    document.querySelectorAll('.row-card-table-course-header').forEach(h => h.classList.remove('active'));

    // Buka yang diklik
    if (!isOpen) {
      content.classList.add('open');
      header.classList.add('active');
    }
  }

  const rows = Array.from(document.querySelectorAll('.row-card-table-course'));
  const paginationContainer = document.getElementById('pagination');
  const limitSelect = document.getElementById('limitSelect');
  const searchInput = document.getElementById('searchCourse');

  let currentPage = 1;
  let limit = parseInt(limitSelect.value);

  function renderPagination(filteredRows) {
    paginationContainer.innerHTML = '';
    const totalPages = Math.ceil(filteredRows.length / limit);

    if (totalPages <= 1) return;

    const prevBtn = document.createElement('button');
    prevBtn.textContent = '‹';
    prevBtn.disabled = currentPage === 1;
    prevBtn.onclick = () => {
      if (currentPage > 1) {
        currentPage--;
        updateDisplay(filteredRows);
      }
    };
    paginationContainer.appendChild(prevBtn);

    for (let i = 1; i <= totalPages; i++) {
      const btn = document.createElement('button');
      btn.textContent = i;
      if (i === currentPage) btn.classList.add('active');
      btn.onclick = () => {
        currentPage = i;
        updateDisplay(filteredRows);
      };
      paginationContainer.appendChild(btn);
    }

    const nextBtn = document.createElement('button');
    nextBtn.textContent = '›';
    nextBtn.disabled = currentPage === totalPages;
    nextBtn.onclick = () => {
      if (currentPage < totalPages) {
        currentPage++;
        updateDisplay(filteredRows);
      }
    };
    paginationContainer.appendChild(nextBtn);
  }

  function updateDisplay(filteredRows) {
    rows.forEach(r => r.style.display = 'none');
    const start = (currentPage - 1) * limit;
    const end = start + limit;
    filteredRows.slice(start, end).forEach(r => r.style.display = '');
    renderPagination(filteredRows);
  }

  function applyFilterAndPaginate() {
    const term = searchInput.value.toLowerCase();
    const filteredRows = rows.filter(r => r.innerText.toLowerCase().includes(term));
    currentPage = 1;
    updateDisplay(filteredRows);
  }

  limitSelect.addEventListener('change', e => {
    limit = parseInt(e.target.value);
    currentPage = 1;
    applyFilterAndPaginate();
  });

  searchInput.addEventListener('input', applyFilterAndPaginate);

  applyFilterAndPaginate();
  // Ambil elemen modal
  const modalEdit = document.getElementById('modalEdit');
  const modalDelete = document.getElementById('modalDelete');

  // Tombol tutup
  document.getElementById('tutupEdit').addEventListener('click', () => modalEdit.classList.add('hidden'));
  document.getElementById('tutupDelete').addEventListener('click', () => modalDelete.classList.add('hidden'));
 
 function openEditModal(data) {
  console.log("Data diterima:", data);
  
  // Buka modal
  modalEdit.classList.remove('hidden');

  // Isi form edit
  document.getElementById('editId').value = data.course_id || data.course_id || '';
  document.getElementById('editTitle').value = data.title || '';
  document.getElementById('editDescription').value = data.description || data.desc || '';
  document.getElementById('editOldImage').value = data.image || '';
  
  // (Opsional) preview gambar lama kalau ada
  const preview = document.getElementById('previewImage');
  if (preview) {
    if (data.image) {
      preview.src = "../uploads/admin/" + data.image;
      preview.style.display = 'block';
    } else {
      preview.style.display = 'none';
    }
  }
}

function openDeleteModal(id) {
  document.getElementById('deleteCourseId').value = id || '';
  modalDelete.classList.remove('hidden');
    // bisa simpan id untuk form PHP nanti
    console.log('Buka modal delete untuk ID:', id);
  }
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../../layouts/mainAdmin.php';
?>