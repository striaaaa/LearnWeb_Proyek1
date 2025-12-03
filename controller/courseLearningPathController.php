<?php

require_once __DIR__ . '/../helpers/url.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/course.php';
require_once __DIR__ . '/../models/module.php';
require_once __DIR__ . '/../models/progress.php';

global $params;
$id = $params['courseId'] ?? null;

$login_token = $_COOKIE['login_token'] ?? NULL;

$userLogin = getUserLogin($login_token)['data'] ?? NULL;
function progressBarData($course_id)
{
    global $userLogin; 
    $getUserCourseProgress =getUserCourseProgress($userLogin->user_id, $course_id)??[];
    return $getUserCourseProgress;
}
if ($id) {
    $courseWithModulesResult = getCourseByIdWithModules2($id, $userLogin->user_id)??[];
}
$courseAll = getAllCourses()??[];

$action = $_GET['action'] ?? $_POST['action'] ?? '';
switch ($action) {
    case 'createFirstProgress':
        createFirstProgress();
        break;

    default:
        # code...
        break;
}
function createFirstProgress()
{
    global $userLogin;
    $course_id = $_POST['course_id'] ?? '';
    $getFirstModule = getModuleByCourseIdAscLimit1($course_id);
    $exist = getUserProgresCheck(
        $userLogin->user_id,
        $getFirstModule['data']->module_id
    );
    // var_dump($exist);
    // die;
    if (!empty((array)$exist['data'])) {
        header("Location: " . basefolder() . "/course/" . $course_id);
        exit;
    }
    $sql = "INSERT INTO progress (user_id, module_id, status) 
            VALUES (?, ?, 'in_progress')";
    runQuery($sql, [$userLogin->user_id, $getFirstModule['data']->module_id], 'ii');

    header("Location: " . basefolder() . "/course/" . $course_id);
    exit;
}

// var_dump($courseWithModulesResult['data']);
