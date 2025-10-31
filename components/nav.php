 <?php require_once __DIR__ . '/../controller/dashboardController.php';  
 
require_once __DIR__ . '/../controller/loginController.php'; 
 ?>
 <div class="nav">
     <div class="logo">Logo</div>
     <div class="nav-link flex items-center">
         <a href="<?=basefolder()?>/"><span>Beranda</span></a>
         <a href="<?=basefolder()?>/course"><span>Kursus</span></a>
         <a href="<?=basefolder()?>/dashboard"><span>Dashboard</span></a>
         <a href="">
             <div class="logout-container" style="text-align: right; margin: 20px;">
      <form  method="post">
        <button type="submit" name="logout" class="logout-btn" style="padding: 8px 16px; background: #e74c3c; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
          Logout
        </button>
      </form>
    </div>
         </a>
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

