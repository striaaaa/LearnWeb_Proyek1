<?php
require_once __DIR__ . '/../../../controller/userController.php';
$page_css = '<link rel="stylesheet" href="'.basefolder().'/assets/css/admin/manajemen-penggguna.css" />';
ob_start();
?>
 
    <div class="">
      <div class="btn-aksi">Filter</div>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Terakhir online</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($userAll['data'] as $key => $user) { ?>
          <tr>
            <td></td>
            <td><?=$user->name?></td>
            <td>
              <span><?=$user->email?></span>
            </td>
            <td><?=$user->created_at?></td>
            <td class=""> 
              <?php if($user->is_active) {?>
              <button class="user-status-btn  user-aktif" id="IuserAktifBtn" onclick='userAktifParseOn(<?=json_encode($user->is_active);?>, <?=json_encode($user->user_id);?>)'>Aktif</button>
              <?php } else {?>
              <button class="user-status-btn  user-nonAktif" id="IuserNonAktifBtn" onclick='userAktifParseOn(<?=json_encode($user->is_active);?>, <?=json_encode($user->user_id);?>)'>Non Aktif</button>
              <?php } ?>
            </td>

        </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div id="userActiveModal" class="modal hidden">
      <div class="modal-content">
        <h3>Ubah status user</h3>
        Status saat ini :
        <form  action="<?= basefolder() ?>/controller/userController.php" method="post">
                <input type="hidden" name="user_id"  id="userIdInput" >
                <input type="hidden" name="is_active" id="isActiveInput" >
                <input type="hidden" name="action" value="updateStatusUser">
          <select name="active" id="isActiveSelect">
            <option value="1">Aktif</option>
            <option value="0">Tidak aktif</option>
          </select>
          <div class="modal-btns">
            <button id="simpanUserActive" type="submit">Simpan</button>
            <button id="tutupUserActive" >Batal</button>
          </div>
        </form>
      </div>
    </div>

    <script>
      const modalUserActive= document.getElementById('userActiveModal');
      const userNoAndAktifBtn = document.querySelectorAll('.user-status-btn'); 
      const saveBtnUserActive = document.getElementById('simpanUserActive');
      const closeBtnUserActive = document.getElementById('tutupUserActive');
      const isActiveSelectOption = document.getElementById('isActiveSelect');  
      const isActiveInput = document.getElementById('isActiveInput');  
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
      // userNoAndAktifBtn.addEventListener('click', openModalUserActive);\
      userNoAndAktifBtn.forEach(btn => {
        btn.addEventListener('click', 

        openModalUserActive
      );
      });
      // userNonAktifBtn.addEventListener('click', openModalUserActive);
      function userAktifParseOn(is_active, user_id){
        console.log('status dan is',status, is_active, user_id);
        isActiveSelectOption.value=is_active;
        isActiveInput.value=is_active;
        userIdInput.value=user_id

      }
    </script>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../../layouts/mainAdmin.php';
?>