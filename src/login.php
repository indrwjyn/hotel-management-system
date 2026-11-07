<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error_msg = 'Username dan password diperlukan';
    } else {
        $stmt = mysqli_prepare($conn, "SELECT password, role FROM users WHERE username = ?");
        if (!$stmt) {
            error_log('MySQL prepare error: ' . mysqli_error($conn));
            $error_msg = 'Terjadi kesalahan server. Periksa log.';
        } else {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) === 1) {
                mysqli_stmt_bind_result($stmt, $db_password, $db_role);
                mysqli_stmt_fetch($stmt);

                $password_ok = password_verify($password, $db_password);

                if ($password_ok && $db_role === 'admin') {
                    session_regenerate_id(true);
                    $_SESSION['login'] = true;
                    header('Location: index.php');
                    exit;
                } else {
                    $error_msg = 'Username atau Password Salah / Akses tidak diizinkan';
                }
            } else {
                $error_msg = 'Username atau Password Salah';
            }

            mysqli_stmt_close($stmt);
        }
    }
}

if (isset($error_msg)) {
    echo "<script>alert('" . addslashes($error_msg) . "');</script>";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Admin Hotel</title>

    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet">

    <link 
        rel="stylesheet" 
        href="asset/css/style.css">

    <link 
        rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

    <div class="login-container">

        <div class="login-card">

            <div class="login-header">

                <div class="hotel-icon">

                    <i class="fa-solid fa-hotel"></i>

                </div>

                <h2>Hotel Management</h2>

                <p>
                    Silakan login sebagai administrator
                </p>

            </div>

            <form method="POST">

                <label class="form-label">
                    Username
                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="fa-solid fa-user"></i>

                    </span>

                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        placeholder="Masukkan username"
                        required>

                </div>

                <label class="form-label">
                    Password
                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="fa-solid fa-lock"></i>

                    </span>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        required>

                </div>

                <button
                    type="submit"
                    name="login"
                    class="btn-login">

                    <i class="fa-solid fa-right-to-bracket"></i>

                    Login Sekarang

                </button>

            </form>

            <div class="divider">

                <span>ATAU</span>

            </div>

            <a
                href="pengunjung.php"
                class="btn-pengunjung">

                <i class="fa-solid fa-bed"></i>

                Pesan Kamar Sebagai Pengunjung

            </a>

            <div class="login-footer">

                © 2026 Hotel Management System

            </div>

        </div>

    </div>

</body>

</html>