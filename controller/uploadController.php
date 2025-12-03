<?php
require_once __DIR__ . '/../helpers/url.php';

require_once __DIR__ . '/../models/user.php';
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
function saveDraft3($data)
{
    if (!$data || !isset($data['content']) || !isset($data['module_id'])) {
        return ['success' => false, 'message' => 'Invalid data'];
    }

    $saveDir = __DIR__ . '/../storage/';
    if (!is_dir($saveDir)) mkdir($saveDir, 0777, true);

    $moduleId = $data['module_id'];
    $fileName = $saveDir . "draft_content_module_{$moduleId}.json";
    $existing = file_exists($fileName)
        ? json_decode(file_get_contents($fileName), true)
        : null;

    $serverNow = time();
    if ($existing && isset($data['client_last_update'])) {
        if ($data['client_last_update'] != $existing['last_updated_server']) {
            return [
                'success' => false,
                'conflict' => true,
                'message' => 'Data berubah, ambil versi terbaru',
                'latest'  => $existing
            ];
        }
    }

    // ---- Simpan versi baru ----
    $newData = [
        "content" => $data['content'],
        "last_updated_server" => $serverNow
    ];

    file_put_contents($fileName, json_encode($newData, JSON_PRETTY_PRINT));

    return [
        "success" => true,
        "message" => "Autosaved",
        "last_updated_server" => $serverNow
    ];
}

function saveDraft2($data)
{


    $login_token = $_COOKIE['login_token'] ?? NULL;
    $userLogin = getUserLogin($login_token)['data'] ?? NULL;
    $moduleId = $data['module_id'];
    $userId = $userLogin->user_id;
    if (!$data || !isset($data['content'])) {
        return ['success' => false, 'message' => 'Invalid data'];
    }

    $saveDir = __DIR__ . '/../storage/';
    if (!is_dir($saveDir)) mkdir($saveDir, 0777, true);


    $userDraft = $saveDir . "draft_module_{$moduleId}_user_{$userId}.json";
    $finalFile = $saveDir . "module_{$moduleId}_final.json";
    file_put_contents($userDraft, json_encode($data['content'], JSON_PRETTY_PRINT));
    $draftFiles = glob($saveDir . "draft_module_{$moduleId}_user_*.json");

    $allDrafts = [];
    foreach ($draftFiles as $file) {
        $allDrafts[] = json_decode(file_get_contents($file), true);
    }
    $merged = mergeEditorJsDrafts($allDrafts);
    file_put_contents($finalFile, json_encode($merged, JSON_PRETTY_PRINT));

    return [
        'success' => true,
        'message' => $data['manual'] ?? false ? 'Draft saved manually' : 'Autosaved',
        'file' => basename($userDraft)
    ];
}
function getFinalModule($moduleId)
{
    // $file = __DIR__ . "/../storage/module_{$moduleId}_final.json";
    // if (!file_exists($file)) return null;
    // return json_decode(file_get_contents($file), true);
    // var_dump($moduleId);
    $fileName = __DIR__ . "/../storage/module_{$moduleId}_final.json";
    if (file_exists($fileName)) {
        $json = file_get_contents($fileName);
        $data = json_decode($json, true);
        return [
            'success' => true,
            'message' => 'Draft ditemukan',
            'data' => $data
        ];
    }
}
function mergeEditorJS($final, $userDraft)
{
    $finalBlocks = [];

    // Map final blocks by ID
    foreach ($final["blocks"] as $b) {
        $finalBlocks[$b["id"]] = $b;
    }

    // Map user draft blocks by ID
    foreach ($userDraft["blocks"] as $b) {
        $id = $b["id"];

        // If block exists → update (last write wins)
        $finalBlocks[$id] = $b;
    } 
    $userBlockIds = array_column($userDraft["blocks"], "id");
    foreach ($finalBlocks as $id => $block) {
        if (!in_array($id, $userBlockIds)) {
            unset($finalBlocks[$id]); // block dihapus
        }
    }

    return [
        "time" => time(),
        "version" => "2.29.1",
        "blocks" => array_values($finalBlocks)
    ];
}

function mergeEditorJsDrafts(array $drafts)
{
    $merged = [
        "time" => time(),
        "blocks" => [],
        "version" => "2.29.1"
    ];
    $blockMap = [];
    foreach ($drafts as $draft) {
        if (!isset($draft['blocks']) || !is_array($draft['blocks'])) {
            continue;
        }

        foreach ($draft['blocks'] as $block) {
            $id = $block["id"];


            if (!isset($blockMap[$id])) {
                $blockMap[$id] = $block;
                continue;
            }

            // Jika sudah ada → last write wins (ambil data terbaru)
            $blockMap[$id]["data"] = $block["data"];
        }
    }
    $merged["blocks"] = array_values($blockMap);
    return $merged;
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
    case 'delete-image':
        deleteImage();
        break;

    default:
        // echo json_encode(['success' => 0, 'message' => 'Invalid action']);
        break;
}


function deleteImage()
{
    $url = $_POST['url'];

    $path = $_SERVER['DOCUMENT_ROOT'] . parse_url($url, PHP_URL_PATH);

    if (file_exists($path)) {
        unlink($path);
    }
    echo json_encode(['success' => 1]);
    exit;
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
