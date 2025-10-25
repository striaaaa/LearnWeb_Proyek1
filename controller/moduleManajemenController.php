<?php

require_once __DIR__ . '/../helpers/url.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/course.php';
 

$courseWithModulesResult= getCourseWithModules2(); 

// var_dump($courseWithModulesResult['data']);
?>