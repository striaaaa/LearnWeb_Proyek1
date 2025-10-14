<?php

require_once __DIR__ . '/../helpers/url.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/course.php';

global $params;
$id = $params['courseId'] ?? null;

$courseWithModulesResult= getCourseByIdWithModules($id);
$courseAll = getAllCourses();

// var_dump($courseWithModulesResult['data']);
?>