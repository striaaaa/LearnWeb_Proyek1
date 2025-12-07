<?php 
function hexToRgb($hex) {
    // hapus hash kalau ada
    $hex = ltrim($hex, '#');

    if (strlen($hex) === 3) {
        // jika short hex, contoh #abc → #aabbcc
        $r = hexdec(str_repeat($hex[0], 2));
        $g = hexdec(str_repeat($hex[1], 2));
        $b = hexdec(str_repeat($hex[2], 2));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }

    return [$r, $g, $b]; // array [r,g,b]
}

if (!function_exists('getDominantColor')) {
    /**
     * Ambil warna dominan dari gambar
     * @param string $imagePath Path ke file image
     * @return string Hex color misal #aabbcc
     */
    function    getDominantColor($imagePath)
    {
        if (!file_exists($imagePath)) return '#cccccc'; // fallback

        // buat resource gambar
        $img = @imagecreatefromstring(file_get_contents($imagePath));
        // var_dump('adda ',$img);
        // die;
        if (!$img) return '#cccccc';

        // resize kecil biar cepat
        $width = imagesx($img);
        $height = imagesy($img);
        $resizeWidth = 50;
        $resizeHeight = (int)($height * ($resizeWidth / $width));
        $tmpImg = imagecreatetruecolor($resizeWidth, $resizeHeight);
        imagecopyresampled($tmpImg, $img, 0,0,0,0, $resizeWidth, $resizeHeight, $width, $height);

        $colors = [];
        for ($x = 0; $x < $resizeWidth; $x++) {
            for ($y = 0; $y < $resizeHeight; $y++) {
                $rgb = imagecolorat($tmpImg, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                $hex = sprintf("#%02x%02x%02x", $r, $g, $b);
                if(isset($colors[$hex])) $colors[$hex]++;
                else $colors[$hex] = 1;
            }
        }

        imagedestroy($img);
        imagedestroy($tmpImg);

        arsort($colors);
        return array_key_first($colors); // warna dominan
    }
}
