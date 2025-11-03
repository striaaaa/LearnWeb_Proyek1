<?php

require_once __DIR__ . '/../helpers/url.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/course.php';
require_once __DIR__ . '/../models/module_content.php';

function getAllModuleContentDatas ($m){
    return getAllModuleContent($m);
}



// $module_content_id = $_POST['module_content_id'] ?? '';
$module_id =  $_POST['module_id'] ?? null; ;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    switch ($action) {
        case 'addOrUpdateModuleContent':
            var_dump($module_id);
            addOrUpdateModuleContent($module_id);
            break;

        default:
            break;
    }
}
function addOrUpdateModuleContent($module_id)
{
    // $fileJsonExist = __DIR__ . '/../storage/draft_content_' . $module_content_id . 'module_' . $module_id . '.json';
    //  $sql = "SELECT id FROM drafts WHERE module_content_id = ? AND module_id = ? LIMIT 1";
    //  if (file_exists($fileJsonExist)) {
    //      $content = file_get_contents($fileJsonExist); 
    //      $jsonEscaped = mysqliEscapeStringg( $content);
    //      $sql = "INSERT INTO modules_content (module_id, content_type, content_data created_at)
    //       VALUES (tes, ?, ? NOW())";
    //      $addContent = runQuery($sql, [$module_content_id, $module_id],    'ii'); 
    //     var_dump($jsonEscaped);
    // } else {
    //     echo json_encode(['success' => false, 'message' => 'Draft tidak ditemukan']);
    // }  
    $fileJsonPath = __DIR__ . '/../storage/draft_content_module_' . $module_id . '.json';

    if (!file_exists($fileJsonPath)) {
        echo json_encode(['success' => false, 'message' => 'Draft tidak ditemukan']);
        return;
    }

    // 🔹 Baca JSON file
    $content = file_get_contents($fileJsonPath);
    $jsonData = json_decode($content, true);

    if (!$jsonData || !isset($jsonData['blocks'])) {
        echo json_encode(['success' => false, 'message' => 'Format JSON tidak valid']);
        return;
    }

    // 🔹 Pisahkan per chunk berdasarkan "type": "chunkDivider"
    $chunks = [];
    $currentChunk = [];
    $chunkIndex = 1;

    foreach ($jsonData['blocks'] as $block) {
        if ($block['type'] === 'chunkDivider') {
            if (!empty($currentChunk)) {
                $chunks[] = [
                    'order_no' => $chunkIndex,
                    'blocks' => $currentChunk
                ];
                $currentChunk = [];
                $chunkIndex++;
            }
        } else {
            $currentChunk[] = $block;
        }
    }

    // simpan chunk terakhir kalau ada
    var_dump($currentChunk);
    if (!empty($currentChunk)) {
        $chunks[] = [
            'order_no' => $chunkIndex,
            'blocks' => $currentChunk
        ];
    }

    // 🔹 Loop tiap chunk untuk insert/update
    foreach ($chunks as $chunk) {
        $order_no = $chunk['order_no'];
        $chunkJson = json_encode($chunk['blocks'], JSON_UNESCAPED_UNICODE);
        $content_type = $chunk['blocks'][0]['type'] ?? 'unknown';

        // cek apakah data sudah ada di DB
        $sqlCheck = "SELECT content_data FROM modules_content 
                     WHERE module_id = ? AND order_no = ? LIMIT 1";
        $checkResult = runQuery($sqlCheck, [$module_id, $order_no], 'ii');
        var_dump('r',$checkResult);

        if ($checkResult && !empty((array)$checkResult)) {
            $row = $checkResult; 
            if ($row!== $chunkJson) {
                $sqlUpdate = "UPDATE modules_content 
                              SET content_type = ?, content_data = ?, created_at = NOW()
                              WHERE module_id = ? AND order_no = ?";
                runQuery($sqlUpdate, [$content_type, $chunkJson, $module_id, $order_no], 'ssii');
            }
        } else {
            
            $sqlInsert = "INSERT INTO modules_content 
                          (module_id, content_type, content_data, order_no, created_at)
                          VALUES ( ?, ?, ?, ?, NOW())";
            runQuery($sqlInsert, [ $module_id, $content_type, $chunkJson, $order_no], 'issi');
        }
    }

        header("Location: " . basefolder() . "/admin/manajemen-modul-konten/21/tambah-konten");
    echo json_encode(['success' => true, 'message' => 'Sinkronisasi chunk berhasil']);


}
