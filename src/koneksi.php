<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "hotel_management";

$conn = mysqli_connect($host, $user, $pass, $db);

if ($conn) {
    mysqli_set_charset($conn, 'utf8mb4');
}

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

?>