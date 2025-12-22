<?php
require_once __DIR__ . '/../controller/dashboardController.php';
require_once __DIR__ . '/../controller/loginController.php';
?>

<div class="nav">

    <!-- LOGO -->
    <div class="logo">
        <a href="<?= basefolder() ?>/">
            <img src="<?= basefolder() ?>/assets/img/image.png" width="150" height="60" style="object-fit:cover;">
        </a>
    </div>

    <!-- DESKTOP NAV -->
    <div class="nav-link">
        <a href="<?= basefolder() ?>/">Beranda</a>
        <a href="<?= basefolder() ?>/course">Kursus</a>
        <a href="<?= basefolder() ?>/dashboard">Dashboard</a>
    </div>

    <!-- RIGHT -->
    <div class="nav-right">

        <?php if (!isset($_COOKIE['login_token'])): ?>
            <div class="log-btn">
                <button class="main-btn-glow-outlined" data-link="<?= basefolder() ?>/login">Login</button>
                <button class="main-btn-glow" data-link="<?= basefolder() ?>/register">Get Started</button>
            </div>
        <?php else: ?>

            <!-- DESKTOP PROFILE -->
            <div class="acc-nav hidden lg:flex" id="profileMenuBtn">
                <p><?= $userLogin->name ?></p>
                <img src="<?= $userLogin->image 
                    ? basefolder().'/uploads/user/profil/'.$userLogin->image 
                    : 'https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3407.jpg'
                ?>">
                <div class="profile-dropdown" id="profileDropdown">
                    <button id="toggleButtonDesktop">Mode Gelap</button>
                    <div class="separator"></div>
                    <form method="post">
                        <button name="logout" class="logout">Logout</button>
                    </form>
                </div>
            </div>

        <?php endif; ?>

        <!-- HAMBURGER -->
        <div class="hamburger" onclick="toggleMobile()">
            <span></span><span></span><span></span>
        </div>

    </div>
</div>

<!-- ================= MOBILE MENU ================= -->
<div id="mobileMenu" class="mobile-menu">

    

    <a href="<?= basefolder() ?>/">Beranda</a>
    <a href="<?= basefolder() ?>/course">Kursus</a>
    <a href="<?= basefolder() ?>/dashboard">Dashboard</a>

    <button id="toggleButtonMobile">Mode Gelap</button>

    <?php if (isset($_COOKIE['login_token'])): ?>
        <form method="post">
            <button name="logout" class="logout">Logout</button>
        </form>
    <?php endif; ?>
</div>
<script>
function toggleMobile() {
    document.getElementById('mobileMenu').classList.toggle('active');
}
 
</script>
