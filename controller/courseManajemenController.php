<?php

require_once __DIR__ . '/../helpers/db_helper.php';
require_once __DIR__ . '/../models/course.php';
 $conn = getMysqliConnection();

$getCourses =getAllCourses();
$action = $_GET['action'] ?? '';

switch ($action) {
  case 'store':
    storeCourse($conn);
    break;
  case 'update':
    updateCourse($conn);
    break;
  case 'delete':
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
    $sql_mod = "INSERT INTO modules (course_id, title, order_no, created_at)
                VALUES ($courseId, '$mod_title', $order_no, NOW())";
    runQuery($sql_mod);
  }
  // die();

  header("Location: ../views/courses_list.php?success=1");
  exit;
}

function updateCourse($conn) {
  // nanti bisa ditambah di sini logika edit/update
}

function deleteCourse($conn) {
  $id = $_GET['id'] ?? 0;
  if (!$id) die("ID tidak valid");

  runQuery("DELETE FROM modules WHERE course_id=$id");
  runQuery("DELETE FROM courses WHERE course_id=$id");

  header("Location: ../views/courses_list.php?deleted=1");
  exit;
}
