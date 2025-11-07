<?php
require_once __DIR__ . '/../controller/dashboardController.php';
$page_css  = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/edit-profil.css">';
renderFlashAlert(); 
ob_start();
?>

<div class="main">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Pengaturan</h2>
        <div class="nav-linkk active" data-target="data-pribadi">
            Data Pribadi
        </div>
        <div class="nav-linkk" data-target="akun">Akun</div>
    </div>

    <div class="content">
        <!-- Data Pribadi -->
        <form action="<?= basefolder() ?>/controller/dashboardController.php?action=editProfil" method="post" enctype="multipart/form-data">
            <div id="data-pribadi" class="card">
                <h3 class="section-title">Data Pribadi</h3>
                <div class="pilih-foto">    
                    <div class="left">
                        <label for="foto">Pilih foto</label>
                        <img
                            id="preview"
                            src="<?= $userLogin->image?basefolder().'/uploads/user/profil/'.$userLogin->image:'https://image.idntimes.com/post/20230220/888355494-47236b76652f2e55025900cd98ccd09e-0759d9cc026a3c781b24c228b3d42224.jpg'?>"
                            class="profile-pic"
                            alt="Foto Profil" />
                    </div>
                    <div class="right">
                        <input
                            type="file"
                            name="image"
                            id="foto"
                            value="Pilih Foto"
                            accept="image/*"
                            onchange="previewFoto(event)" />
                        <p>
                            Gambar Profile Anda sebaiknya memiliki rasio 1:1 dan berukuran
                            tidak lebih dari 2MB.
                        </p>
                    </div>
                </div>
                <label>Nama Lengkap</label>
                <input type="text" name="name" value="<?= $userLogin->name ?>" placeholder="Masukkan nama lengkap" />

                <label>Email</label>
                <input type="email" name="email" value="<?= $userLogin->email ?>" disabled />

                <label>Alamat</label>
                <textarea rows="3" name="alamat" placeholder="Masukkan alamat"> <?= $userLogin->alamat ?> </textarea>

                <!-- <label>Nomor Telepon</label>
            <input type="text" placeholder="Masukkan nomor telepon" /> -->

                <button>Simpan Perubahan</button>
            </div>
        </form>

        <!-- Akun -->
        <div id="akun" class="card hidden">
            <h3 class="section-title">Akun</h3>
     <form action="<?= basefolder() ?>/controller/dashboardController.php?action=changePassword" method="post">
            <label class="top">Email</label>
            <input type="email" name="email" value="<?= $userLogin->email ?>" disabled />
            <label>Password Lama</label>
            <input type="password" name="password_lama" placeholder="Masukkan password lama" />
            <label>Password Baru</label>
            <input type="password" name="password_baru" placeholder="Masukkan password baru" />

            <label>Konfirmasi Password</label>
            <input type="password" name="confirm_password" placeholder="Ulangi password baru" />

            <button>Ubah Password</button>
     </form>
        </div>
    </div>
</div>

<!-- JS -->
<?php include __DIR__ . '/../components/footer.php'; ?>
<?php
$page_js  = '<script src="' . basefolder() . '/assets/js/edit-profil.js"></script>';
?>
<?php
$content = ob_get_clean();

include __DIR__ . '/../layouts/mainUser.php';
?>