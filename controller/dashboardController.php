<?php
require_once __DIR__ . '/../helpers/url.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../components/alert.php';


$mysqli = getMysqliConnection();

$baseFolder = basefolder();
$login_token = $_COOKIE['login_token'] ?? NULL;
$userLogin = getUserLogin($login_token)['data'] ?? NULL;

if (!empty($userLogin) && isset($userLogin->created_at)) {
    $userLogin->created_at = date('Y', strtotime($userLogin->created_at));
}
$action = $_GET['action'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($action) {
        case 'editProfil':
            // var_dump("sas");
            editProfil();
            break;
        case 'changePassword':
            // var_dump("sas");
            changePassword();
            break;
        default:
            break;
    }
}
function changePassword()
{
    global $login_token;
    $old_password = trim($_POST['password_lama'] ?? '');
    $new_password = trim($_POST['password_baru'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    $errors = [];

    // 🔹 Validasi dasar
    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $errors[] = "Semua field wajib diisi.";
    }

    if ($new_password !== $confirm_password) {
        $errors[] = "Password baru dan konfirmasi tidak sama.";
    }

    // Kalau ada error awal, langsung balikin
    if (!empty($errors)) {
        setFlashAlert('error', $errors[0]);
        header("Location: " . basefolder() . "/dashboard/edit-profile");
        exit;
    }
 
    $sql = "SELECT password FROM users WHERE login_token = ?";
    $user = runQuery($sql, [$login_token], 's', true);

    if (!$user) {
        setFlashAlert('error', 'User tidak ditemukan.');
        header("Location: " . basefolder() . "/dashboard/edit-profile");
        exit;
    }

    $hashedPassword = $user->password;
 
    if (!password_verify($old_password, $hashedPassword)) {
        setFlashAlert('error', 'Password lama salah.');
        header("Location: " . basefolder() . "/dashboard/edit-profile");
        exit;
    }
 
    if (password_verify($new_password, $hashedPassword)) {
        setFlashAlert('error', 'Password baru tidak boleh sama dengan password lama.');
        header("Location: " . basefolder() . "/dashboard/edit-profile");
        exit;
    }
 
    $newHashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
 
    $updateSql = "UPDATE users SET password = ? WHERE login_token = ?";
    $result = runQuery($updateSql, [$newHashedPassword, $login_token], 'ss');

    if ($result) {
        setFlashAlert('success', 'Password berhasil diperbarui.');
    } else {
        setFlashAlert('error', 'Gagal memperbarui password.');
    }

    header("Location: " . basefolder() . "/dashboard/edit-profile");
    exit;
}
function editProfil()
{
    global $login_token;

    $name   = $_POST['name'] ?? "";
    $alamat = $_POST['alamat'] ?? "";
    $errors = [];



    $oldUser = runQuery("SELECT image FROM users WHERE login_token = ?", [$login_token], 's');
    $oldImage = $oldUser->image ?? null;
    // var_dump($oldUser->image);
    // die();

    $newImage = $oldImage;
    // echo $_FILES['image']??'';

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/user/profil/";

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Buat nama baru biar unik
        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        // die();
        $targetPath = $targetDir . $imageName;
        // var_dump($_FILES['image']??'', file_exists($targetDir));

        // Upload file baru
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath)) {
            if (!empty($oldImage) && file_exists($targetDir . $oldImage)) {
                unlink($targetDir . $oldImage);
            }
            $newImage = $imageName;
        } else {
            $errors[] = "Gagal mengupload gambar baru.";
        }
    }



    if (empty($name)) $errors[] = "Nama tidak boleh kosong.";
    if (empty($alamat)) $errors[] = "Alamat tidak boleh kosong.";

    if (!empty($errors)) {
        setFlashAlert('error', $errors[0]);
        header("Location: " . basefolder() . "/dashboard/edit-profile");
        exit;
    }


    $sql = "UPDATE users SET name = ?, alamat = ?, image = ? WHERE login_token = ?";
    $result = runQuery($sql, [$name, $alamat, $newImage, $login_token], 'ssss');

    if ($result) {
        setFlashAlert('success', 'Profil berhasil diperbarui.');
    } else {
        setFlashAlert('error', 'Gagal memperbarui profil.');
    }

    header("Location: " . basefolder() . "/dashboard/edit-profile?asd");
    exit;
}
