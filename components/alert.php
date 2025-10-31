<?php

function showAlert($type, $message)
{
    return "
    <link rel='stylesheet' href='" . basefolder() . "/assets/css/alert.css'>
    <div class='alert {$type}'>
        " . htmlspecialchars($message) . "
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
      const alertBox = document.querySelector('.alert');
      if (alertBox) {
        setTimeout(() => alertBox.remove(), 3000);
      }
    });
    </script>
    ";
}

/**
 * Simpan alert sementara menggunakan cookie (flash)
 */
function setFlashAlert($type, $message)
{
    setcookie(
        'flash_alert',
        json_encode(['type' => $type, 'msg' => $message]),
        time() + 3,
        '/'
    );
}

function renderFlashAlert()
{
    if (!isset($_COOKIE['flash_alert'])) return;

    $alert = json_decode($_COOKIE['flash_alert'], true);
    if (!$alert) return;

    echo showAlert($alert['type'], $alert['msg']);

    setcookie('flash_alert', '', time() - 3600, '/');
}
