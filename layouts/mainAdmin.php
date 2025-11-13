<?php
$current = basename($_SERVER['REQUEST_URI']);

require_once __DIR__ . '/../controller/loginController.php';
require_once __DIR__ . '/../controller/dashboardController.php';
renderFlashAlert();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Homepage</title>
    <link rel="stylesheet" href="<?= basefolder() ?>/assets/css/global.css" />
    <link rel="stylesheet" href="<?= basefolder() ?>/assets/css/admin/global-admin.css" />
    <link rel="stylesheet" href="<?= basefolder() ?>/assets/css/admin/side-bar.css" />
    <?php if (isset($page_css)) echo $page_css; ?>
    <?php if (isset($page_css2)) echo $page_css2; ?>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sora:wght@100..800&display=swap"
        rel="stylesheet" />
    <style>
      
    </style>
</head>

<body>
    <div class="side-bar">
        <div class="logo">
            <img src="../assets/img/image.png" height="60px" width="100%" alt="" srcset="" style="object-fit: cover;">
        </div>
        <div class="nav-link-admin">
            <div class="btn-link <?= ($current == 'dashboard') ? 'is-active is-active-line' : '' ?>">
                <a href="<?= basefolder() ?>/admin/dashboard">
                    <div class="flex items-center">
                        <img src="../assets/img/icon/dashboard.svg" height="24px" width="24px" alt="" srcset="" style="object-fit: cover;">
                        <p>
                            &nbsp;
                            Dashboard
                        </p>
                    </div>
                </a>
            </div>

            <div class="btn-link <?= ($current == 'manajemen-pengguna') ? 'is-active is-active-line' : '' ?>">
                <a href="<?= basefolder() ?>/admin/manajemen-pengguna">
                    <div class="flex items-center">
                        <img src="../assets/img/icon/user.svg" height="24px" width="24px" alt="" srcset="" style="object-fit: cover;">
                        <p>
                            &nbsp;
                            Pengguna
                        </p>
                    </div>
                </a>
            </div>

            <div class="btn-link <?= ($current == 'manajemen-kursus') ? 'is-active is-active-line' : '' ?>">
                <a href="<?= basefolder() ?>/admin/manajemen-kursus">
                    <div class="flex items-center">
                        <img src="../assets/img/icon/kursus.svg" height="24px" width="24px" alt="" srcset="" style="object-fit: cover;">
                        <p>
                            &nbsp;
                            Kursus
                        </p>
                    </div>
                </a>
            </div>

            <div class="btn-link <?= ($current == 'manajemen-modul') ? 'is-active is-active-line' : '' ?>">
                <a href="<?= basefolder() ?>/admin/manajemen-modul">
                    <div class="flex items-center">
                        <img src="../assets/img/icon/modul.svg" height="24px" width="24px" alt="" srcset="" style="object-fit: cover;">
                        <p>
                            &nbsp;
                            Modul
                        </p>
                    </div>
                </a>
            </div>

            <div class="btn-link <?= ($current == 'manajemen-modul-konten') ? 'is-active is-active-line' : '' ?>">
                <a href="<?= basefolder() ?>/admin/manajemen-modul-konten">
                    <div class="flex items-center">
                        <img src="../assets/img/icon/konten.svg" height="24px" width="24px" alt="" srcset="" style="object-fit: cover;">
                        <p>
                            &nbsp;
                            Konten
                        </p>
                    </div>
                </a>
            </div>

            <form method="post">
                <button type="submit" name="logout" class="logout-btn">
                    Logout
                </button>
            </form>
        </div>

    </div>
    <div class="admin-content-parent">
        <div class="admin-content">
            <!-- <div class="header-admin flex justify-end items-center">
                <div class="flex items-center">
                    <div>

                        <p>
                            <?= $userLogin->name  ?>
                        </p>
                        <p class="role-admin-teks">Admin</p>
                    </div>
                    <div class="img-acc-nav">
                        <img src="<?= $userLogin->image ? basefolder() . '/uploads/user/profil/' . $userLogin->image : 'https://image.idntimes.com/post/20230220/888355494-47236b76652f2e55025900cd98ccd09e-0759d9cc026a3c781b24c228b3d42224.jpg' ?>" alt="user" />
                    </div>
                </div>
            </div> -->
          <div class="header-admin flex justify-end items-center relative">
                <div class="flex items-center " id="profileMenuBtn">
                    <div>
                        <p class="font-semibold text-gray-800"><?= $userLogin->name ?></p>
                        <p class="role-admin-teks ">Admin</p>
                    </div>
                    <div class="img-acc-nav">
                        <img src="<?= $userLogin->image ? basefolder() . '/uploads/user/profil/' . $userLogin->image : 'https://image.idntimes.com/post/20230220/888355494-47236b76652f2e55025900cd98ccd09e-0759d9cc026a3c781b24c228b3d42224.jpg' ?>"
                            alt="user" class="w-full h-full object-cover" />
                    </div>
                </div>

                <!-- Dropdown Menu -->
                <div id="profileDropdown" class="dropdown">
                    <!-- <a href="#" class="">Profil</a>
                    <a href="#" class="">Pengaturan</a> -->
                    
                </div>
            </div>
            <div class="admin-content-body">
                <?php if (isset($content)) echo $content; ?>
            </div>
        </div>
    </div>

    <script>
        const profileMenuBtn = document.getElementById('profileMenuBtn');
        const profileDropdown = document.getElementById('profileDropdown');

        profileMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            profileDropdown.classList.toggle('show');
        });

        document.addEventListener('click', () => {
            profileDropdown.classList.remove('show');
        });

        profileDropdown.addEventListener('click', (e) => e.stopPropagation());
        //         document.querySelectorAll('.btn-link').forEach(btn => {
        //   btn.addEventListener('click', () => {
        //     const target = btn.getAttribute('data-href');
        //     if (target) window.location.href = target;
        //   });
        // });
        // document.querySelectorAll('.btn-link').forEach(div => {
        //     div.addEventListener('click', e => {
        //         const link = div.querySelector('a');
        //         if (link) link.click();
        //     });
        // }); 
        // document.querySelectorAll('.btn-link').forEach(btn => {
        //   const text = btn.querySelector('span').textContent.trim().toLowerCase();
        //   const iconContainer = document.createElement('span');
        //   iconContainer.classList.add('icon');

        //   // cocokan teks dengan key di icons.js
        //   if (icons[text]) {
        //     iconContainer.innerHTML = icons[text];
        //     btn.querySelector('a').prepend(iconContainer);
        //   }
        // }); 
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>