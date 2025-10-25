<?php
$current = basename($_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Homepage</title>
    <link rel="stylesheet" href="<?= basefolder() ?>/assets/css/global.css" />
    <link rel="stylesheet" href="<?= basefolder() ?>/assets/css/admin/side-bar.css" />
    <?php if (isset($page_css)) echo $page_css; ?>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sora:wght@100..800&display=swap"
        rel="stylesheet" />
</head>

<body>
    <div class="side-bar">
        <div class="logo">INI LOGO</div>
        <div class="nav-link">
            <a href="<?= basefolder() ?>/admin/dashboard"
                class="<?= ($current == 'dashboard') ? 'is-active' : '' ?>">
                <span>Dashboard</span>
            </a>
            <a href="<?= basefolder() ?>/admin/manajemen-pengguna"
                class="<?= ($current == 'manajemen-pengguna') ? 'is-active' : '' ?>">
                <span>Manajemen Pengguna</span>
            </a>
            <a href="<?= basefolder() ?>/admin/manajemen-kursus"
                class="<?= ($current == 'manajemen-kursus') ? 'is-active' : '' ?>">
                <span>Manajemen Kursus</span>
            </a>
            <a href="<?= basefolder() ?>/admin/manajemen-modul"
                class="<?= ($current == 'manajemen-modul') ? 'is-active' : '' ?>">
                <span>Manajemen Modul</span>
            </a>
        </div>
    </div>

    <div class="content">
        <?php if (isset($content)) echo $content; ?>
    </div>


</body>

</html>