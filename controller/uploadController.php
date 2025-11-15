<?php
require_once __DIR__ . '/../helpers/url.php';
// require_once __DIR__ . '/../helpers/db_helper.php';
// header('Content-Type: application/json');
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Allow-Headers: Content-Type");

// Aktifkan debug kalau perlu
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$action = $_GET['action'] ?? $_POST['action'] ?? '';

// function saveDraft($data) {
//     if (!$data || !isset($data['content'])) {
//         return ['success'=>false,'message'=>'Invalid data'];
//     }

//     $saveDir = __DIR__ . '/../../storage/';
//     if (!is_dir($saveDir)) mkdir($saveDir, 0777, true);

//     $userId = $data['user_id'] ?? 1;
//     $fileName = $saveDir . 'draft_user_'.$userId.'.json';

//     $saved = file_put_contents($fileName, json_encode($data['content'], JSON_PRETTY_PRINT));

//     return [
//         'success'=>$saved!==false,
//         'message'=>$data['manual'] ?? false ? 'Draft disimpan manual':'Autosaved',
//         'file'=>basename($fileName)
//     ];
// }
function response($data, $status = 200)
{
    http_response_code($status);
    echo json_encode($data, JSON_PRETTY_PRINT);
    exit;
}
 
function saveDraft($data)
{   
    if (!$data || !isset($data['content'])) {
        return ['success' => false, 'message' => 'Invalid data'];
    }
    $saveDir = __DIR__ . '/../storage/';
    if (!is_dir($saveDir)) mkdir($saveDir, 0777, true);

//    $random_string = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
    $moduleId = $data['module_id'] ?? 'unknown';
    $fileName = $saveDir . "draft_content_module_{$moduleId}.json";

    $testPath = $saveDir . 'test.txt';
    file_put_contents($testPath, 'cek');
    $saved = file_put_contents($fileName, json_encode($data['content'], JSON_PRETTY_PRINT));

    return [
        'success' => $saved !== false,
        'message' => $data['manual'] ?? false ? 'Draft disimpan manual' : 'Autosaved',
        'file' => basename($fileName)
    ];
}
$dataTempFinal = [];
// ====== HANDLER: GET DRAFT ======
function getDraft($moduleId)    
{
    $fileName = __DIR__ . "/../storage/draft_content_module_{$moduleId}.json";
    if (file_exists($fileName)) {
        $json = file_get_contents($fileName);
        $data = json_decode($json, true);
        return [
            'success' => true,
            'message' => 'Draft ditemukan',
            'data' => $data
        ];
    }
    return [
        'success' => false,
        'message' => 'Tidak ada draft tersimpan'
    ];
}
// $dataTempFinal= getDraft($module_content_id, $moduleId);
switch ($action) {
    //  case 'autosave':
    //     $response = saveDraft($data);
    //     break; 
    case 'autosave':
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        $result = saveDraft($data);
        response($result);
        break;

    case 'manualSave':
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        $data['manual'] = true;
        $result = saveDraft($data);
        response($result);
        break;

    // case 'getDraft':
    //     $module_content_id =  1;
    //     $moduleId =  10;
    //     $response = getDraft($module_content_id, $moduleId);
    //     response($dataTempFinal);
    //     break;
    case 'upload-image':
        uploadImage();
        break;

    case 'fetch-image':
        fetchImage();
        break;

    default:
        // echo json_encode(['success' => 0, 'message' => 'Invalid action']);
        break;
}



function uploadImage()
{
    $uploadDir = __DIR__ . '/../uploads/admin/moduleContent/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    if (empty($_FILES)) {
        echo json_encode(['success' => 0, 'message' => 'No file uploaded']);
        return;
    }


    $fileKey = isset($_FILES['image']) ? 'image' : 'file';
    $fileTmpPath = $_FILES[$fileKey]['tmp_name'];
    $fileName = basename($_FILES[$fileKey]['name']);
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($fileExtension, $allowedExt)) {
        echo json_encode(['success' => 0, 'message' => 'File type not allowed']);
        return;
    }

    $newFileName = uniqid('img_', true) . '.' . $fileExtension;
    $destPath = $uploadDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        $fileUrl = buildFileUrl('uploads/admin/moduleContent/' . $newFileName);
        echo json_encode([
            'success' => 1,
            'file' => ['url' => $fileUrl]
        ]);
    } else {
        echo json_encode(['success' => 0, 'message' => 'Failed to move file']);
    }
}



function fetchImage()
{
    $url = $_POST['url'] ?? '';
    if (!$url) {
        echo json_encode(['success' => 0, 'message' => 'No URL provided']);
        return;
    }

    $imgData = @file_get_contents($url);
    if (!$imgData) {
        echo json_encode(['success' => 0, 'message' => 'Failed to fetch image']);
        return;
    }

    $uploadDir = __DIR__ . '/../uploads/admin/moduleContent/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
    if (!$ext) $ext = 'jpg';

    $newFileName = uniqid('img_url_', true) . '.' . $ext;
    file_put_contents($uploadDir . $newFileName, $imgData);

    $fileUrl = buildFileUrl('uploads/admin/moduleContent/' . $newFileName);
    echo json_encode([
        'success' => 1,
        'file' => ['url' => $fileUrl]
    ]);
}


function buildFileUrl($relativePath)
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $baseUrl = $protocol . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    return basefolder() . '/' . ltrim($relativePath, '/');
}
