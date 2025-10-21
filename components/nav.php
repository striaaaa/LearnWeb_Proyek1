 <?php require_once __DIR__ . '/../controller/dashboardController.php';  
 ?>
 <div class="nav">
     <div class="logo">Logo</div>
     <div class="nav-link">
         <a href="<?=basefolder()?>/"><span>Beranda</span></a>
         <a href="<?=basefolder()?>/course"><span>Kursus</span></a>
         <a href="<?=basefolder()?>/dashboard"><span>Dashboard</span></a>
     </div>
     <?php if (!isset($_COOKIE['login_token'])): ?>
         <div class="log-btn">
            <a class="regist-btn" href="<?=basefolder()?>/register">
                Daftar
            </a>
            <a class="login-btn" href="<?=basefolder()?>/login">
                Masuk
            </a>
        </div>
     <?php else: ?>
         <div class="acc-nav">
             <div class="name-acc-nav">
                 <span><?=$userLogin->name; ?></span>
             </div>
             <div class="img-acc-nav">
                 <img src="../assets/user.png" alt="user" />
             </div>
         </div>
     <?php endif; ?>
 </div>

