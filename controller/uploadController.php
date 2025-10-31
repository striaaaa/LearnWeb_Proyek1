<?php
require_once __DIR__ . '/../helpers/url.php';
// require_once __DIR__ . '/../helpers/db_helper.php';
// header('Content-Type: application/json');
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Allow-Headers: Content-Type");

// Aktifkan debug kalau perlu
error_reporting(E_ALL);
ini_set('display_errors', 1);

$action = $_GET['action'] ?? $_POST['action'] ?? '';
function saveDraft($data) {
    if (!$data || !isset($data['content'])) {
        return ['success'=>false,'message'=>'Invalid data'];
    }

    $saveDir = __DIR__ . '/../../storage/';
    if (!is_dir($saveDir)) mkdir($saveDir, 0777, true);

    $userId = $data['user_id'] ?? 1;
    $fileName = $saveDir . 'draft_user_'.$userId.'.json';

    $saved = file_put_contents($fileName, json_encode($data['content'], JSON_PRETTY_PRINT));

    return [
        'success'=>$saved!==false,
        'message'=>$data['manual'] ?? false ? 'Draft disimpan manual':'Autosaved',
        'file'=>basename($fileName)
    ];
}
switch ($action) {
     case 'autosave':
        $response = saveDraft($data);
        break; 
    case 'upload-image':
        uploadImage();
        break;

    case 'fetch-image':
        fetchImage();
        break;

    default:
        echo json_encode(['success' => 0, 'message' => 'Invalid action']);
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
