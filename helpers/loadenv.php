<?php
function loadEnv(string $path = __DIR__ . '/../.env') {
    if(!file_exists($path)) return;

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach($lines as $line) {
        // skip komentar
        if(str_starts_with(trim($line), '#')) continue;

        // pisah key=value
        if(strpos($line, '=') !== false){
            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            putenv("$key=$value");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}