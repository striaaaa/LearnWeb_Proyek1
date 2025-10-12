 <?php require_once __DIR__ . '/../models/user.php'; ?>
 <div class="nav">
     <div class="logo">Logo</div>
     <div class="nav-link">
         <a href=""><span>Beranda</span></a>
         <a href="learning-path.html"><span>Learning Path</span></a>
         <a href=""><span>Dashboard</span></a>
     </div>
     <?php if (!isset($_COOKIE['login_token'])): ?>
         <div class="log-btn">
            <a href="<?=basefolder()?>/login">
                <div class="regist-btn">Daftar</div>
            </a>
             <div class="login-btn">Masuk</div>
         </div>
     <?php else: ?>
         <div class="acc-nav">
             <div class="name-acc-nav">
                 <span><?=$user['name'] ?? 'Nama Akun'; ?></span>
             </div>
             <div class="img-acc-nav">
                 <img src="../assets/user.png" alt="user" />
             </div>
         </div>
     <?php endif; ?>
 </div>


 <div class="container-1">
     <div class="left_content_1">
         <div class="header_content_1">
             <p>Belajar Web Development Dasar dengan Mudah</p>
         </div>
         <div class="sub_header_content_1">
             <p>Materi terstruktur untuk mahasiswa baru Teknik Informatika</p>
         </div>
         <div class="btn_content_1">
             <span>Belajar Sekarang</span>
         </div>
     </div>
     <div class="right_content_1">
         <div class="box-img-1">
             <img src="https://" alt="ini gambar" />
         </div>
     </div>
 </div>