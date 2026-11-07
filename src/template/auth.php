<?php
// Dipanggil di awal halaman admin. Mengarahkan ke login jika belum masuk.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}
