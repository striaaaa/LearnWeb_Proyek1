<?php
require_once __DIR__ . '/../helpers/url.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/module.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/progress.php';
require_once __DIR__ . '/../models/course.php';
require_once __DIR__ . '/../components/alert.php';


$action = $_GET['action'] ?? $_POST['action'] ?? '';

$allCourseWithModules = getCoursesWithModulesLimit3();
$module_id = $_POST['module_id'] ?? '';
$prev_module_id = $_POST['prev_module_id'] ?? '';
$order_no = $_POST['order_no'] ?? '';

$login_token = $_COOKIE['login_token'] ?? NULL;

$userLogin = getUserLogin($login_token)['data'] ?? NULL;

switch ($action) {
    case 'getUserProgresCheck':
        getUserProgresCheckData();
        break;
    case 'prevModuleContent':
        prevModuleContent();
        break;
    case 'nextModuleContent':
        nextModuleContent();
        break;

    default:
        # code...
        break;
}
function getUserProgresCheckData()
{
    global $userLogin, $module_id , $prev_module_id, $order_no;
    $course_id = $_POST['course_id'] ?? '';
    // var_dump($course_id);
    // die();

    $getUserLastProgres = getUserLastProgres($userLogin->user_id);
    $order = intval($order_no);
    $prevOrderNoResult =  $order - 1;
    // var_dump($prev_module_id);
    // var_dump($module_id);

    $prevModuleExist = prevModuleExist($prev_module_id,$prevOrderNoResult);
   
    // var_dump($prevModuleExist['data']);  
    if ($prevModuleExist['data']->module_id > 0) {

        if ($prevOrderNoResult == 0) {
            $dataModuleExist = prevModuleExist($prev_module_id,$prevOrderNoResult += 1);
            if (!empty((array)$dataModuleExist['data'])) {
                $sql = "INSERT INTO progress (user_id, module_id, status) 
                    VALUES (?, ?, 'in_progress') 
                    ON DUPLICATE KEY UPDATE updated_at = NOW()";
                runQuery($sql, [$userLogin->user_id, $module_id], 'ii');
            }
            header("Location: " . basefolder() . "/course/" . $course_id . "/detailModule/" . $module_id);
            exit;
        }
        $prevProgress = getUserProgresCheck($userLogin->user_id, $prevModuleExist['data']->module_id);
        $getModuleById = getModuleById($getUserLastProgres['data']->module_id);

        // Cek loncat module jauh
        // var_dump($prevProgress['data']);
        var_dump($prevModuleExist['data']->module_id);
        if (intval($order) - intval($getModuleById['data']->order_no) > 1) {
            setFlashAlert('error', 'Module sebelumnya belum diselesaikan .');
            header("Location: " . basefolder() . "/course/" . $course_id);

            exit;
        }

        // die;
        if (empty((array)$prevProgress['data'])) {
            setFlashAlert('error', 'Module sebelumnya belum pernah dikerjakan.');
            header("Location: " . basefolder() . "/course/" . $course_id);
            exit;
        }

        $statusProgressCheck = $prevProgress['data']->status ?? '';
        // var_dump($statusProgressCheck);
        // die;
        if ($statusProgressCheck !== 'completed') {
            setFlashAlert('error', 'Module sebelumnya belum diselesaikan.');
            header("Location: " . basefolder() . "/course/" . $course_id);
            exit;
        }

        if ((array)$prevProgress['data'] && $statusProgressCheck === 'completed') {
            $sql = "INSERT INTO progress (user_id, module_id, status) 
                    VALUES (?, ?, 'in_progress') 
                    ON DUPLICATE KEY UPDATE updated_at = NOW()";
            runQuery($sql, [$userLogin->user_id, $module_id], 'ii');
        }
        var_dump('diluar rsmua');
        header("Location: " . basefolder() . "/course/" . $course_id . "/detailModule/" . $module_id);
    }
}

function prevModuleContent()
{
    $module_id = $_POST['module_id'] ?? '';
    $course_id = $_POST['course_id'] ?? '';
    if (!$module_id || !$course_id) {
        setFlashAlert('error', 'Data module tidak valid.');
        header("Location: " . basefolder() . "/course/" . $course_id);
        exit;
    }

    // Ambil data module sekarang
    $currentModule = getModuleById($module_id)['data'] ?? null;

    $currentOrder = intval($currentModule->order_no);
    $prevModule = getModuleByOrder($course_id, $currentOrder - 1);
    if ($module_id - 1 > 0) {
        header("Location: " . basefolder() . "/course/" . $course_id . "/detailModule/" . $prevModule['data']->module_id);
        exit;
    } else {
        setFlashAlert('info', 'Anda sudah berada dimodul paling pertama.');
        header("Location: " . basefolder() . "/course/" . $course_id . "/detailModule/" . $module_id);
        exit;
    }
}
function nextModuleContent()
{
    global $userLogin;

    $module_id = $_POST['module_id'] ?? '';
    $course_id = $_POST['course_id'] ?? '';

    if (!$module_id || !$course_id) {
        setFlashAlert('error', 'Data module tidak valid.');
        header("Location: " . basefolder() . "/course/" . $course_id);
        exit;
    }

    // data module skrng
    $currentModule = getModuleById($module_id)['data'] ?? null;
    if (!$currentModule) {
        setFlashAlert('error', 'Module tidak ditemukan.');
        header("Location: " . basefolder() . "/course/" . $course_id);
        exit;
    }

    $currentOrder = intval($currentModule->order_no);

    //  module selanjutnya berdasarkan order_no
    // var_dump($currentOrder);
    // die();
    $nextModule = getModuleByOrder($course_id, $currentOrder + 1);
    $sql = "INSERT INTO progress (user_id, module_id, status)
            VALUES (?, ?, 'completed')
            ON DUPLICATE KEY UPDATE status = 'completed', updated_at = NOW()";
    runQuery($sql, [$userLogin->user_id, $module_id], 'ii');
    if ((empty((array)$nextModule['data']))) {
        setFlashAlert('info', 'Anda sudah berada di modul terakhir.');
        header("Location: " . basefolder() . "/course/" . $course_id . "/detailModule/" . $module_id);
        exit;
    }

    $sql = "INSERT INTO progress (user_id, module_id, status)
            VALUES (?, ?, 'in_progress')
            ON DUPLICATE KEY UPDATE updated_at = NOW()";
    runQuery($sql, [$userLogin->user_id, $nextModule['data']->module_id], 'ii');

    header("Location: " . basefolder() . "/course/" . $course_id . "/detailModule/" . $nextModule['data']->module_id);
    exit;
}

function getUserProgresCheckData2()
{
    global $userLogin, $module_id, $order_no;
    // var_dump($order_no);
    // die();
    $getUserLastProgres = getUserLastProgres($userLogin->user_id);
    $order = intval($order_no);
    $prevOrderNoResult = ($order - 1 == 0) ? $order  : $order - 1;
    // var_dump($prevOrderNoResult);

    $prevModuleExist = prevModuleExist($module_id,$prevOrderNoResult);

    // var_dump('moduel ',$prevModuleExist['data']);

    // $getUserProgresCheck = getUserProgresCheck($userLogin->user_id, $module_id);
    if ($prevModuleExist['data']->module_id > 1) {
        $prevProgress = getUserProgresCheck($userLogin->user_id, $prevModuleExist['data']->module_id);

        $getModuleById = getModuleById($getUserLastProgres['data']->module_id);
        // var_dump($getModuleById['data']->order_no);
        if (intval($order) - intval($getModuleById['data']->order_no) > 1) {
            echo "Module sebelumnya belum diselesaikan";
            return;
        } else {

            if (empty((array)$prevProgress['data'])) {
                echo "Module sebelumnya belum pernah dikerjakan";
                return;
            }
            $statusProgressCheck = $prevProgress['data']->status ?? '';

            if ($statusProgressCheck !== 'completed') {
                echo "Module sebelumnya belum selesai";
                return;
            }
            if ((array)$prevProgress['data'] && $statusProgressCheck === 'completed') {
                $sql = "INSERT INTO progress (user_id, module_id, status) VALUES (?, ?, 'in_progress') ON DUPLICATE KEY UPDATE updated_at = NOW()";
                runQuery($sql, [$userLogin->user_id, $module_id], 'ii');
                return;
            }
        }
    } else {
        echo "Ini modeule pertama";
        return;
    }
    // var_dump(($getUserProgresCheck['data']));
    // if (empty((array)$getUserProgresCheck['data'])) {
    //     // $sql ="INSERT INTO progress (user_id, module_id, status) VALUES (?, ?, 'in_progress') ON DUPLICATE KEY UPDATE updated_at = NOW()";
    //     // runQuery($sql,[$userLogin->user_id, $module_id],'ii');
    //     echo "kosong";
    // } else {
    //     echo "ada isinya";
    // }
}
