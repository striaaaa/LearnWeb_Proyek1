<?php
require_once __DIR__ . '/../../../controller/userController.php';
$page_css = '
<link rel="stylesheet" href="' . basefolder() . '/assets/css/admin/manajemen-pengguna.css" />
<link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet"/>
';

ob_start();
?>

<style>
</style>

<div class="table-controls"><!-- HTML: gantikan input lama dengan ini -->
  <div class="search-wrapper" role="search" aria-label="Cari pengguna">
    <!-- SVG search icon -->
    <svg class="search-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg">
      <path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
      <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>

    <input
      type="text"
      id="customSearch"
      class="search-input"
      placeholder="Cari pengguna..."
      aria-label="Cari pengguna">
  </div>

  <!-- <select id="filterStatus" class="filter-select">
    <option value="">Semua Status</option>
    <option value="Aktif">Aktif</option>
    <option value="Non Aktif">Non Aktif</option>
  </select> -->

  <select id="limitSelect" class="limit-select">
    <option value="5">5</option>
    <option value="10" selected>10</option>
    <option value="25">25</option>
    <option value="50">50</option>
  </select>
</div>

<div id="myTableWrapper"></div>

<!-- Modal ubah status -->
<div id="userActiveModal" class="modal hidden">
  <div class="modal-content">
    <h3>Ubah status user</h3>
    <p>Status saat ini:</p>
    <form action="<?= basefolder() ?>/controller/userController.php" method="post">
      <input type="hidden" name="user_id" id="userIdInput">
      <input type="hidden" name="action" value="updateStatusUser">
      <select name="isActiveInput" id="isActiveSelect">
        <option value="1">Aktif</option>
        <option value="0">Tidak aktif</option>
      </select>
      <div class="modal-btns">
        <button id="simpanUserActive" type="submit">Simpan</button>
        <button id="tutupUserActive">Batal</button>
      </div>
    </form>
  </div>
</div>

<script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
<script>
  const {
    Grid,
    html
  } = gridjs;

  // Ambil data user dari PHP
  const userData = <?= json_encode($userAll['data']); ?>;

  // Bentuk array untuk Grid.js
  const gridData = userData.map(user => [
    user.user_id,
    user.name,
    user.email,
    user.created_at,
    html(
      user.is_active ?
      `<button class="user-status-btn user-aktif" onclick='userAktifParseOn(${user.is_active}, ${user.user_id})'>Aktif</button>` :
      `<button class="user-status-btn user-nonAktif" onclick='userAktifParseOn(${user.is_active}, ${user.user_id})'>Non Aktif</button>`
    )
  ]);

  let originalData = [...gridData];
  let currentSearch = '';
  let currentStatus = '';
  let currentLimit = 10; // default limit

  // Inisialisasi Grid
  const grid = new Grid({
    columns: ['ID', 'Nama', 'Email', 'Terakhir online', 'Status'],
    data: gridData,
    search: false,
    sort: true,
    pagination: {
      enabled: true,
      limit: currentLimit
    },
    style: {
      table: {
        border: 'none',
        'border-radius': '10px',
        
        'background-color': '#ffffff',
        padding: '20px',

        margin: '0 0 20px 0',
      },
      th: {
        'background-color': '#ffffff', // header biru
        color: '#393939ff',
        border: 'none',
         
        'border-bottom': '20px solid #f9f9fb',
        'font-weight': '600', 
        'text-align': 'center',
        padding: '20px'
      }, 
      td: {
        border: 'none',
        'border-bottom': '20px solid #f9f9fb',
        'text-align': 'center',
        padding: '20px',
        'border-radius': '10px',
        'background-color': '#ffffff',
        color: '#111827'
      }
    },
    row: (row, rowIndex) => {
      row.style.transition = 'background-color 0.2s';
      row.style.backgroundColor = rowIndex % 2 === 0 ? '#f9fafb' : '#ffffff';

      row.onmouseover = () => {
        row.style.backgroundColor = '#e0f2fe';
      };
      row.onmouseout = () => {
        row.style.backgroundColor = rowIndex % 2 === 0 ? '#f9fafb' : '#ffffff';
      };
    },
  }).render(document.getElementById("myTableWrapper"));

  // Fungsi apply filter dan render ulang
  function applyFilters() {
    const filtered = originalData.filter(row => {
      const matchesSearch = row.some(cell =>
        typeof cell === "string" && cell.toLowerCase().includes(currentSearch)
      );
      return matchesSearch;
    });

    const sorted = filtered.sort((a, b) => {
      if (!currentStatus) return 0;
      const statusA = (a[4]?.props?.content || '').toLowerCase();
      const statusB = (b[4]?.props?.content || '').toLowerCase();

      const matchA = statusA.includes(currentStatus);
      const matchB = statusB.includes(currentStatus);

      if (matchA && !matchB) return -1;
      if (!matchA && matchB) return 1;
      return 0;
    });

    grid.updateConfig({
      data: sorted,
      pagination: {
        enabled: true,
        limit: currentLimit,
        page: 1
      }
    }).forceRender();
  }

  // Event: Search
  document.getElementById('customSearch').addEventListener('input', (e) => {
    currentSearch = e.target.value.toLowerCase().trim();
    applyFilters();
  });


  // Event: Ganti limit
  document.getElementById('limitSelect').addEventListener('change', (e) => {
    currentLimit = parseInt(e.target.value);
    applyFilters();
  });

  // Modal logic
  const modalUserActive = document.getElementById('userActiveModal');
  const closeBtnUserActive = document.getElementById('tutupUserActive');
  const saveBtnUserActive = document.getElementById('simpanUserActive');
  const isActiveSelectOption = document.getElementById('isActiveSelect');
  const userIdInput = document.getElementById('userIdInput');

  function openModalUserActive() {
    modalUserActive.classList.remove('hidden');
  }
  closeBtnUserActive.addEventListener('click', (e) => {
    e.preventDefault();
    modalUserActive.classList.add('hidden');
  });
  saveBtnUserActive.addEventListener('click', () => {
    modalUserActive.classList.add('hidden');
  });

  function userAktifParseOn(is_active, user_id) {
    isActiveSelectOption.value = is_active ? 1 : 0;
    userIdInput.value = user_id;
    openModalUserActive();
  }
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../../layouts/mainAdmin.php';
?>