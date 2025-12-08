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

        <?php if (isset($_COOKIE['login_token'])): ?>
            <form method="post">
                <button type="submit" name="logout" class="logout-btn"
                    style="padding: 8px 16px; background:#e74c3c; color:#fff; border:none; border-radius:4px;">
                    Logout
                </button>
            </form>
        <?php endif; ?>
    </div>

    <!-- THEME SWITCH -->
  

    <!-- DESKTOP LOGIN -->
     <div class="flex items-center">

         <?php if (!isset($_COOKIE['login_token'])): ?>
            <div class="log-btn">
                <button class="main-btn-glow-outlined" data-link="<?= basefolder() ?>/login">Login</button>
            <button class="main-btn-glow" data-link="<?= basefolder() ?>/register">Get Started</button>
        </div>

    <?php else: ?>
        <div class="acc-nav">
            <div class="name-acc-nav"><p><?= $userLogin->name; ?></p></div>
            <div class="img-acc-nav">
                <img src="<?= $userLogin->image ? basefolder().'/uploads/user/profil/'.$userLogin->image : 'https://i.pravatar.cc/150' ?>">
            </div>
        </div>
        <?php endif; ?> 
          <div class="nav-theme ml-4">
        <button id="toggleButton" class="btn-theme">
            <i id="icon" class="toggle-dark-mode ri-sun-fill" style="font-size: 24px"></i>
        </button>
    </div>
    </div>
    <!-- HAMBURGER -->
    <div class="hamburger" onclick="toggleMobile()">
        <span></span>
        <span></span>
        <span></span>
    </div>

</div>

<!-- MOBILE MENU -->
<div id="mobileMenu" class="mobile-menu">

    <a href="<?= basefolder() ?>/">Beranda</a>
    <a href="<?= basefolder() ?>/course">Kursus</a>
    <a href="<?= basefolder() ?>/dashboard">Dashboard</a>

    <?php if (!isset($_COOKIE['login_token'])): ?>

        <button class="main-btn-glow-outlined" data-link="<?= basefolder() ?>/login">Login</button>
        <button class="main-btn-glow" data-link="<?= basefolder() ?>/register">Get Started</button>

    <?php else: ?>

        <div class="mobile-account">
            <p><?= $userLogin->name ?></p>
            <img style="width:50px; height:50px; border-radius:50%;" 
                 src="<?= $userLogin->image ? basefolder().'/uploads/user/profil/'.$userLogin->image : 'https://i.pravatar.cc/150' ?>">
        </div>

        <form method="post">
            <button type="submit" name="logout" style="padding:8px 16px; background:#e74c3c; color:#fff; border:none; border-radius:4px;">
                Logout
            </button>
        </form>

    <?php endif; ?>

</div>


<script>
function toggleMobile() {
    const m = document.getElementById("mobileMenu");
    m.style.display = m.style.display === "flex" ? "none" : "flex";
}
</script>
