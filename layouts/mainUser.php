<?php
// require_once __DIR__ . '/../helpers/url.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Homepage</title>
    <link rel="stylesheet" href="assets/css/nav.css" />
    <?php if (isset($page_css)) echo $page_css; ?>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sora:wght@100..800&display=swap"
      rel="stylesheet"
    />
  </head>
<body>
    
<!-- <?=basefolder();?> -->
    <?php include __DIR__ . '/../components/nav.php'; ?>

    <div class="container">
        <?php if (isset($content)) echo $content; ?>
    </div>

    <!-- <?php include __DIR__ . '/../components/footer.php'; ?> -->
</body>
</html>
