<?php
require_once __DIR__ . '/../helpers/url.php';
require_once __DIR__ . '/../models/user.php'; 
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/course.php';

$allCourseWithModules= getCoursesWithModulesLimit3();


?>