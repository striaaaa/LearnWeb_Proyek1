<?php

require_once __DIR__ . '/../helpers/url.php';

require_once __DIR__ . '/../helpers/db_helper.php';
require_once __DIR__ . '/../models/course.php';

 $conn = getMysqliConnection();

$getCourses =getAllCourses();
$action = $_GET['action'] ?? '';

switch ($action) {
  case 'store':
    storeCourse($conn);
    break;
  case 'updateCourse':
    // var_dump('asd');
    updateCourse($conn);
    break;
  case 'deleteCourse':
    deleteCourse($conn);
    break;
  default: 
    break;
}

function storeCourse($conn) {
  $title = $_POST['title'] ?? '';
  $desc = $_POST['description'] ?? '';
  $modules = json_decode($_POST['modulesData'] ?? '[]', true);

  if (!$title || !$desc) {
    die('Data kursus belum lengkap!');
  }

  // upload image
  $imageName = null;
  // var_dump($_FILES['courseImage']);
  // die();
  if (!empty($_FILES['courseImage']['name'])) {
    $targetDir = "../uploads/admin/";
    if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
    $imageName = time() . "_" . basename($_FILES["courseImage"]["name"]);
    move_uploaded_file($_FILES["courseImage"]["tmp_name"], $targetDir . $imageName);
  }

  // simpan course
  $sql = "INSERT INTO courses (title, description, image, created_at)
          VALUES ('" . mysqli_real_escape_string($conn, $title) . "',
                  '" . mysqli_real_escape_string($conn, $desc) . "',
                  '" . mysqli_real_escape_string($conn, $imageName) . "',
                  NOW())";

  $insertResult=runQuery($sql);
  $courseId = $insertResult['insert_id'];
  
  // simpan modul
  foreach ($modules as $m) {
    // var_dump($m, $courseId);
    $mod_title = mysqli_real_escape_string($conn, $m['title']);
    $order_no = intval($m['order_no']);
    $learning_time = intval($m['learning_time']);
    $sql_mod = "INSERT INTO modules (course_id, title, order_no, learning_time, created_at)
                VALUES ($courseId, '$mod_title', $order_no, $learning_time, NOW())";
    runQuery($sql_mod);
  }
  // die();

   header("Location: " . basefolder() . "/admin/manajemen-kursus");
  exit;
}
function updateCourse($conn)
{
  $id = $_POST['course_id'] ?? 0;
  $title = $_POST['title'] ?? '';
  $desc = $_POST['description'] ?? '';
  $oldImage = $_POST['oldImage'] ?? ''; 

  if (!$id || !$title || !$desc) {
    die('Data kursus belum lengkap untuk update!');
  }

  $imageName = $oldImage;
  if (!empty($_FILES['courseImage']['name'])) {
    $targetDir = "../uploads/admin/";
    if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
    $fileExt = pathinfo($_FILES["courseImage"]["name"], PATHINFO_EXTENSION);
    $uniqueName = uniqid('course_', true) . '.' . strtolower($fileExt);

    $targetFile = $targetDir . $uniqueName;
    if (move_uploaded_file($_FILES["courseImage"]["tmp_name"], $targetFile)) {
      //dlete gambar lama jika ada
      if ($oldImage && file_exists($targetDir . $oldImage)) {
        unlink($targetDir . $oldImage);
      }
      $imageName = $uniqueName;
    } else {
      die('Gagal mengupload gambar baru.');
    }
    
  //  header("Location: " . basefolder() . "/admin/manajemen-kursus");
  }

  // Update course
  $sql = "UPDATE courses
          SET title = '" . mysqli_real_escape_string($conn, $title) . "',
              description = '" . mysqli_real_escape_string($conn, $desc) . "',
              image = '" . mysqli_real_escape_string($conn, $imageName) . "'
          WHERE course_id = " . intval($id);

  $result = runQuery($sql);

  // var_dump($result);
  
   header("Location: " . basefolder() . "/admin/manajemen-kursus");
  exit;
}


function deleteCourse($conn)
{
  $id = $_POST['course_id'] ?? 0;
  if (!$id) die('ID kursus tidak ditemukan!');

  // Hapus image jika ada
  $result = runQuery("SELECT image FROM courses WHERE course_id = " . intval($id));
  var_dump($result->image);
  if (!empty($result->image)) {
    $targetDir = "../uploads/admin/";
    $oldImage = $result->image;
    if (file_exists($targetDir . $oldImage)) {
      unlink($targetDir . $oldImage);
    }
  }

  // Hapus modules & course
  runQuery("DELETE FROM modules WHERE course_id = " . intval($id));
  runQuery("DELETE FROM courses WHERE course_id = " . intval($id));

  header("Location: " . baseFolder() . "/admin/manajemen-kursus");
  exit;
}