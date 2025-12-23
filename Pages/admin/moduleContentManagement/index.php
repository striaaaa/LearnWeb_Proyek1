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
</style><div class="table-controls">
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

<div id="courseList">
  <!-- Header -->
  <div class="row-card-table-header">
    <div class="grid grid-cols-12">
      <div class="col-span-1"><h4>No.</h4></div>
      <div class="col-span-3"><h4>Judul</h4></div>
      <div class="col-span-4"><h4>Deskripsi</h4></div>
      <div class="col-span-3"><h4>Dibuat pada</h4></div>
      <div class="col-span-1"><h4>Aksi</h4></div>
    </div>
  </div>

  <!-- Data kursus -->
  <?php foreach ($courseWithModulesResult['data'] as $index => $course): ?>
    <div class="row-card-table-course">
      <div class="grid grid-cols-12 items-center row-card-table-course-header" onclick="toggleAccordion(this)">
        <div class="col-span-1"><p><?= $index + 1 ?>.</p></div>
        <div class="col-span-3"><p><?= htmlspecialchars($course->title) ?></p></div>
        <div class="col-span-4"><p><?= htmlspecialchars($course->description) ?></p></div>
        <div class="col-span-3"><p><?= htmlspecialchars($course->created_at ?? '-') ?></p></div>
        <div class="col-span-1 flex justify-end items-center">
          <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 12 24">
            <path fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z" transform="rotate(-180 5.02 9.505)" />
          </svg>
        </div>
      </div>

      <div class="accordion-content">
        <div class="module-list" id="module-list-<?= htmlspecialchars($course->course_id) ?>">
          <?php foreach ($course->modules as $k => $module): ?>
            <div class="grid grid-cols-12 module-card items-center">
              <div class="col-span-1 flex items-center justify-between" style="padding-right: 40px;">
                <p><?= $k + 1 ?></p>
              </div>
              <div class="col-span-8">
                <p><?= htmlspecialchars($module->title) ?></p>
              </div>
              <div class="col-span-3 flex">
                <a href="<?= basefolder() ?>/admin/manajemen-modul-konten/<?= $module->module_id ?>/tambah-konten" class="btn-aksi-default" style="margin-right:5px;">
                  tambah konten
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<div class="pagination" id="pagination" style="margin-top:15px;"></div>

<script>
  // Accordion
  function toggleAccordion(header) {
    const content = header.nextElementSibling;
    const isOpen = content.classList.contains('open');
    document.querySelectorAll('.accordion-content').forEach(c => c.classList.remove('open'));
    document.querySelectorAll('.row-card-table-course-header').forEach(h => h.classList.remove('active'));
    if (!isOpen) {
      content.classList.add('open');
      header.classList.add('active');
    }
  }

  // Search + Pagination
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
    prevBtn.onclick = () => { if (currentPage > 1) { currentPage--; updateDisplay(filteredRows); } };
    paginationContainer.appendChild(prevBtn);

    for (let i = 1; i <= totalPages; i++) {
      const btn = document.createElement('button');
      btn.textContent = i;
      if (i === currentPage) btn.classList.add('active');
      btn.onclick = () => { currentPage = i; updateDisplay(filteredRows); };
      paginationContainer.appendChild(btn);
    }

    const nextBtn = document.createElement('button');
    nextBtn.textContent = '›';
    nextBtn.disabled = currentPage === totalPages;
    nextBtn.onclick = () => { if (currentPage < totalPages) { currentPage++; updateDisplay(filteredRows); } };
    paginationContainer.appendChild(nextBtn);
  }

  function updateDisplay(filteredRows) {
    rows.forEach(r => r.style.display = 'none');
    const start = (currentPage - 1) * limit;
    const end = start + limit;
    const visibleRows = filteredRows.slice(start, end);
    visibleRows.forEach(r => r.style.display = '');

    if (filteredRows.length === 0) {
      if (!document.getElementById('noResults')) {
        const msg = document.createElement('div');
        msg.id = 'noResults';
        msg.textContent = 'Tidak ada kursus yang sesuai.';
        document.getElementById('courseList').appendChild(msg);
      }
    } else {
      const noRes = document.getElementById('noResults');
      if (noRes) noRes.remove();
    }

    renderPagination(filteredRows);
  }

  function applyFilterAndPaginate() {
    const term = searchInput.value.toLowerCase();
    const filteredRows = rows.filter(r => {
      const title = r.querySelector('.col-span-3 p')?.innerText.toLowerCase() ?? '';
      const desc = r.querySelector('.col-span-4 p')?.innerText.toLowerCase() ?? '';
      return title.includes(term) || desc.includes(term);
    });
    currentPage = 1;
    updateDisplay(filteredRows);
  }

  limitSelect.addEventListener('change', e => {
    limit = parseInt(e.target.value);
    currentPage = 1;
    applyFilterAndPaginate();
  });

  let debounceTimeout;
  searchInput.addEventListener('input', () => {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(applyFilterAndPaginate, 300);
  });

  // Inisialisasi
  applyFilterAndPaginate();
</script>



<?php
$content = ob_get_clean();
include __DIR__ . '/../../../layouts/mainAdmin.php';
?>