<?php

/* ================= ROUNDED MASK ================= */
function roundedMask($w, $h, $r)
{
    $mask = imagecreatetruecolor($w, $h);
    imagesavealpha($mask, true);
    imagealphablending($mask, false);

    $transparent = imagecolorallocatealpha($mask, 0, 0, 0, 127);
    $solid       = imagecolorallocatealpha($mask, 255, 255, 255, 0);

    imagefill($mask, 0, 0, $transparent);

    // tengah
    imagefilledrectangle($mask, $r, 0, $w - $r, $h, $solid);
    imagefilledrectangle($mask, 0, $r, $w, $h - $r, $solid);

    // sudut
    imagefilledellipse($mask, $r, $r, $r * 2, $r * 2, $solid);
    imagefilledellipse($mask, $w - $r, $r, $r * 2, $r * 2, $solid);
    imagefilledellipse($mask, $r, $h - $r, $r * 2, $r * 2, $solid);
    imagefilledellipse($mask, $w - $r, $h - $r, $r * 2, $r * 2, $solid);

    return $mask;
}

/* ================= MAIN ================= */
function generateCourseCover(
    array $post,
    array $file,
    string $saveDir,
    string $mode = 'preview'
) {

    if (empty($file['tmp_name']) || !file_exists($file['tmp_name'])) {
        http_response_code(400);
        exit('No image uploaded');
    }

    $post['modulesData'] = json_decode($post['modulesData'] ?? '[]', true);
    // var_dump($post['modulesData']);
    // die;

    /* ================= ICON ================= */
    $tmp  = $file['tmp_name'];
    $type = mime_content_type($tmp);

    $icon = ($type === 'image/png')
        ? imagecreatefrompng($tmp)
        : imagecreatefromjpeg($tmp);

    // ambil warna dominan icon
    $tiny = imagecreatetruecolor(1, 1);
    imagecopyresampled($tiny, $icon, 0, 0, 0, 0, 1, 1, imagesx($icon), imagesy($icon));
    $rgb = imagecolorat($tiny, 0, 0);

    $r = ($rgb >> 16) & 0xFF;
    $g = ($rgb >> 8) & 0xFF;
    $b = $rgb & 0xFF;

    /* ================= CANVAS ================= */
    $w = 325;
    $h = 200;

    $img = imagecreatetruecolor($w, $h);
    imagealphablending($img, true);
    imagesavealpha($img, true);

    // gradient background
    $angle = 0;
    $rad   = deg2rad($angle);
    $dx    = cos($rad);
    $dy    = sin($rad);
    $len   = abs($dx) * $w + abs($dy) * $h;

    for ($y = 0; $y < $h; $y++) {
        for ($x = 0; $x < $w; $x++) {
            $t = ($x * $dx + $y * $dy) / $len;
            $t = max(0, min(1, $t));

            $color = imagecolorallocate(
                $img,
                $r + (255 - $r) * $t,
                $g + (255 - $g) * $t,
                $b + (255 - $b) * $t
            );
            imagesetpixel($img, $x, $y, $color);
        }
    }

    /* ================= GLASS CARD ================= */
    $cardW  = 183;
    $cardH  = 168;
    $cardX  = 16;
    $cardY  = 16;
    $radius = 16;

    $card = imagecreatetruecolor($cardW, $cardH);
    imagecopy($card, $img, 0, 0, $cardX, $cardY, $cardW, $cardH);

    // blur background card
    for ($i = 0; $i < 6; $i++) {
        imagefilter($card, IMG_FILTER_GAUSSIAN_BLUR);
    }

    imagealphablending($card, true);
    imagesavealpha($card, true);

    // overlay glass
    $glass = imagecolorallocatealpha($card, 255, 255, 255, 85);
    imagefilledrectangle($card, 0, 0, $cardW, $cardH, $glass);

    // rounded mask
    $mask = roundedMask($cardW, $cardH, $radius);
    imagealphablending($card, false);
    imagesavealpha($card, true);

    for ($y = 0; $y < $cardH; $y++) {
        for ($x = 0; $x < $cardW; $x++) {
            $alpha = (imagecolorat($mask, $x, $y) >> 24) & 0x7F;
            if ($alpha === 127) {
                imagesetpixel(
                    $card,
                    $x,
                    $y,
                    imagecolorallocatealpha($card, 0, 0, 0, 127)
                );
            }
        }
    }
    imagedestroy($mask);

    imagecopy($img, $card, $cardX, $cardY, 0, 0, $cardW, $cardH);

    /* ================= TEXT ================= */
    $fontBold = "../assets/Poppins/Poppins-Bold.ttf";
    $fontReg  = "../assets/Poppins/Poppins-Regular.ttf";

    if (!file_exists($fontBold) || !file_exists($fontReg)) {
        http_response_code(500);
        exit('Font not found');
    }

    $white = imagecolorallocate($img, 255, 255, 255);
    $black = imagecolorallocate($img, 0, 0, 0);

    // judul di card
    imagettftext(
        $img,
        22,
        0,
        $cardX + 16,
        $cardY + 36,
        $white,
        $fontBold,
        $post['coverTitle']
    );

    // list module
    $yText = $cardY + 70;
 $modules = array_slice($post['modulesData'] ?? [], 0, 3);

foreach ($modules as $item) { 
    $title = $item['title'] ?? '';
    
    imagettftext(
        $img,
        12,
        0,
        $cardX + 24,
        $yText,
        $white,
        $fontReg,
        "• $title"
    );
    $yText += 18;
}

    /* ================= ICON KANAN ================= */
    imagecopyresampled(
        $img,
        $icon,
        215,
        60,
        0,
        0,
        90,
        90,
        imagesx($icon),
        imagesy($icon)
    );

    imagettftext(
        $img,
        22,
        0,
        220,
        50,
        $black,
        $fontBold,
        $post['coverTitle']
    );

    /* ================= OUTPUT ================= */
    if ($mode === 'preview') {
        header("Content-Type: image/png");
        imagepng($img);
        exit;
    }

    if ($mode === 'return') {
        return [
            'image'    => $img,
            'filename' => 'cover_' . time() . '.png'
        ];
    }

    if (!file_exists($saveDir)) {
        mkdir($saveDir, 0777, true);
    }

    $path = rtrim($saveDir, '/') . '/cover_' . time() . '.png';
    imagepng($img, $path);

    return $path;
}
