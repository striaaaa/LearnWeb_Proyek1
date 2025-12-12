<?php 
require_once __DIR__ . '/../controller/dashboardController.php';
require_once __DIR__ . '/../controller/loginController.php';
?>
 


<div class="nav">

    <!-- LOGO -->
    <div class="logo">
        <img src="<?= basefolder() ?>/assets/img/image.png" height="60" width="150" style="object-fit: cover;">
    </div>

    <!-- DESKTOP NAV -->
    <div class="nav-link flex items-center">
        <a href="<?= basefolder() ?>/"><span>Beranda</span></a>
        <a href="<?= basefolder() ?>/course"><span>Kursus</span></a>
        <a href="<?= basefolder() ?>/dashboard"><span>Dashboard</span></a>
    </div>

    <!-- RIGHT SIDE -->
    <div class="flex items-center">

        <?php if (!isset($_COOKIE['login_token'])): ?>

            <div class="log-btn">
                <button class="main-btn-glow-outlined" data-link="<?= basefolder() ?>/login">Login</button>
                <button class="main-btn-glow" data-link="<?= basefolder() ?>/register">Get Started</button>
            </div>

        <?php else: ?>

            <!-- PROFILE (DESKTOP DROPDOWN) -->
            <div class="acc-nav" id="profileMenuBtn">
                <p><?= $userLogin->name; ?></p>
                <img style="width:45px; height:45px; border-radius:50%; object-fit:cover;"
                     src="<?= $userLogin->image ? basefolder().'/uploads/user/profil/'.$userLogin->image : 'https://i.pravatar.cc/150' ?>">

                <!-- DROPDOWN -->
                <div class="profile-dropdown" id="profileDropdown">

                    <!-- DESKTOP DARK MODE -->
                    <button id="toggleButtonDesktop">
                        <i id="iconDesktop" class="ri-sun-fill"></i> Mode Gelap
                    </button>

                    <div class="separator"></div>

                    <!-- DESKTOP LOGOUT -->
                    <form method="post">
                        <button type="submit" name="logout" style="color:#e74c3c;">
                            Logout
                        </button>
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




<!-- MOBILE MENU -->
<div id="mobileMenu" class="mobile-menu">

    <a href="<?= basefolder() ?>/">Beranda</a>
    <a href="<?= basefolder() ?>/course">Kursus</a>
    <a href="<?= basefolder() ?>/dashboard">Dashboard</a>

    <!-- MOBILE DARK MODE LIST -->
    <button id="toggleButtonMobile">
        <i id="iconMobile" class="ri-sun-fill"></i> Mode Gelap
    </button>

    <!-- MOBILE LOGOUT LIST -->
    <?php if (isset($_COOKIE['login_token'])): ?>
        <form method="post">
            <button type="submit" name="logout" style="color:#e74c3c;">
                Logout
            </button>
        </form>
    <?php endif; ?>

</div>




<script>
</script>
