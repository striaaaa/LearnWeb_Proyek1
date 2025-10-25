<?php

function base_url()
{
    // otomatis sesuai environment
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    return $protocol . "://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
}
// var_dump(base_url());
// die();
function basefolder()
{
    $url = $_SERVER['REQUEST_URI'];
    $segments = explode('/', trim($url, '/'));
   return '/' . $segments[0];
}
function get_segments()
{
    // var_dump($_SERVER['SCRIPT_NAME']); # /learnweb/index.php

    // var_dump(dirname($_SERVER['SCRIPT_NAME'])); # ambil dir paling atas/learnweb
    $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); # /learnweb
    // var_dump(rtrim(dirname(('/learnweb/')),'\/'));
    $uri      = $_SERVER['REQUEST_URI']; # /learnweb/admin/user/edit/5
    //     " " (spasi)
    // "\n" (new line)
    // "\r" (carriage return)
    // "\t" (tab)
    // "\v" (vertical tab)
    // "\0" (null byte)

    // buang query string
    if (($qpos = strpos($uri, '?')) !== false) {
        $uri = substr($uri, 0, $qpos);
    }

    // buang base path /learnWeb 
    $path = substr($uri, strlen($basePath)); //hilangkan /learnweb
    // var_dump($path); # /admin/user/edit/5
    $path = trim($path, '/');
    // var_dump($path); # trim kiiri kanan    admin/user/edit/5

    return $path === '' ? [] : explode('/', $path); //dipecah per /
}

function url_segment($index)
{
    $segments = get_segments();
    return $segments[$index] ?? '';
}


function potong_text($tulisan, $count)
{

    if (strlen($tulisan) <= $count) {
        return $tulisan;
    }

    $i = $count;
    while ($i > 0 && substr($tulisan, $i, 1) != " ") {
        $i--;
    }

    $tulisan = substr($tulisan, 0, $i > 0 ? $i : $count);

    return $tulisan . " (...)";
}

$current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
 
$base = basefolder(); 


if (strpos($current_path, $base) === 0) {
    $current_path = substr($current_path, strlen($base));
}
// Pastikan path diawali dengan slash
if (substr($current_path, 0, 1) !== '/') {
    $current_path = '/' . $current_path;
}
 
function is_active_link($target_path, $current_path) { 
    if (substr($target_path, 0, 1) !== '/') {
        $target_path = '/' . $target_path;
    }
     
    if ($current_path === $target_path) {
        return 'is-active';
    }
     
    if (strpos($current_path, $target_path) === 0 && $target_path !== '/') {
        return 'is-active';
    }
    
    return '';
}
?>