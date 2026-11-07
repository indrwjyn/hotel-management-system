<?php
include 'koneksi.php';

if(isset($_GET['id'])){

    // sanitize id to prevent SQL issues
    $id = intval($_GET['id']);

    // =========================
    // AMBIL DATA TAMU
    // =========================
    $sql = "SELECT * FROM tamu WHERE id_tamu = '$id'";
    $query = mysqli_query($conn, $sql);
    if (!$query) {
        error_log("Query error (tamu): " . mysqli_error($conn)); die("Terjadi kesalahan pada server.");
    }

    $data = mysqli_fetch_array($query);

    // Jika data tidak ditemukan
    if(!$data){

        die("Data tamu tidak ditemukan!");

    }

    // =========================
    // MEMBUAT KODE BOOKING
    // =========================
    $kode_booking = "HTL-" . date("Y") . "-" . sprintf('%03d', $data['id_tamu']);



    // =========================
    // AMBIL DATA KAMAR
    // =========================
    $kamar = $data['kamar'];

    $kamar_esc = mysqli_real_escape_string($conn, $kamar);
    $sqlKamar = "SELECT * FROM kamar WHERE tipe_kamar = '$kamar_esc'";
    $queryKamar = mysqli_query($conn, $sqlKamar);
    if (!$queryKamar) {
        error_log("Query error (kamar): " . mysqli_error($conn)); die("Terjadi kesalahan pada server.");
    }

    $dataKamar = mysqli_fetch_array($queryKamar);

    // Harga kamar: hitung total berdasarkan jumlah malam
    $price_per_night = floatval($dataKamar['harga'] ?? 0);
    $check_in_date = $data['check_in'] ?? null;
    $check_out_date = $data['check_out'] ?? null;

    if ($check_in_date && $check_out_date) {
        $diff_seconds = strtotime($check_out_date) - strtotime($check_in_date);
        $nights = intval(floor($diff_seconds / 86400));
        if ($nights <= 0) {
            $nights = 1; // aman
        }
    } else {
        $nights = 1;
    }

    $total_bayar = $price_per_night * $nights;



    // =========================
    // DATA TRANSAKSI
    // Cari reservasi yang terkait dengan tamu ini; jika tidak ada, buat reservasi baru
    // =========================

    $tanggal_bayar = date("Y-m-d");
    $metode_bayar = "Transfer";
    $status_bayar = "lunas";

    // Coba dapatkan reservasi yang sudah ada untuk tamu ini
    $sqlReservasi = "SELECT * FROM reservasi WHERE id_tamu = '$id' ORDER BY id_reservasi DESC LIMIT 1";
    $qRes = mysqli_query($conn, $sqlReservasi);
    if (!$qRes) {
        error_log("Query error (reservasi lookup): " . mysqli_error($conn)); die("Terjadi kesalahan pada server.");
    }

    if (mysqli_num_rows($qRes) > 0) {
        $rowRes = mysqli_fetch_array($qRes);
        $id_reservasi = $rowRes['id_reservasi'];
    } else {
        // Tidak ada reservasi — buat reservasi baru menggunakan data tamu dan kamar
        $id_kamar_val = $dataKamar['id_kamar'] ?? NULL;
        $tanggal_pesan = date('Y-m-d');
        $check_in_val = $data['check_in'] ?? NULL;
        $check_out_val = $data['check_out'] ?? NULL;
        $total_harga_val = $total_bayar;
        $status_reservasi_val = 'booking';

        $sqlInsertRes = "INSERT INTO reservasi
            (id_tamu, id_kamar, tanggal_pesan, check_in, check_out, total_harga, status_reservasi)
            VALUES
            ('$id', '$id_kamar_val', '$tanggal_pesan', '$check_in_val', '$check_out_val', '$total_harga_val', '$status_reservasi_val')";

        $resInsRes = mysqli_query($conn, $sqlInsertRes);
        if (!$resInsRes) {
            error_log("Insert error (reservasi): " . mysqli_error($conn)); die("Terjadi kesalahan pada server.");
        }

        $id_reservasi = mysqli_insert_id($conn);
    }



    // =========================
    // CEK AGAR TRANSAKSI TIDAK DOUBLE
    // =========================
    $cek = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_reservasi = '$id_reservasi'");

    if(mysqli_num_rows($cek) == 0){

        $sqlInsert = "INSERT INTO transaksi
            (id_reservasi, tanggal_bayar, metode_bayar, total_bayar, status_bayar)
            VALUES
            ('$id_reservasi', '$tanggal_bayar', '$metode_bayar', '$total_bayar', '$status_bayar')";

        $resIns = mysqli_query($conn, $sqlInsert);
        if (!$resIns) {
            error_log("Insert error (transaksi): " . mysqli_error($conn)); die("Terjadi kesalahan pada server.");
        }

    }

} else {

    header("location:pengunjung.php");
    exit;

}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tiket Reservasi Hotel</title>

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

    <div class="ticket-container">

        <div class="ticket-card">

            <div class="ticket-top">

                <div class="ticket-logo">

                    <i class="fa-solid fa-hotel"></i>

                </div>

                <h2>HOTEL LUXURY</h2>

                <p>
                    Luxury Modern Hotel Reservation
                </p>

            </div>

            <div class="ticket-status">

                <i class="fa-solid fa-circle-check"></i>

                Booking Berhasil

            </div>

            <div class="ticket-code">

                <?= $kode_booking; ?>

            </div>

            <div class="ticket-info">

                <div class="ticket-row">

                    <span>Nama Tamu</span>

                    <strong><?= $data['nama']; ?></strong>

                </div>

                <div class="ticket-row">

                    <span>No HP</span>

                    <strong><?= $data['hp']; ?></strong>

                </div>

                <div class="ticket-row">

                    <span>Alamat</span>

                    <strong><?= $data['alamat']; ?></strong>

                </div>

                <div class="ticket-row">

                    <span>Tipe Kamar</span>

                    <strong><?= $data['kamar']; ?></strong>

                </div>

                <div class="ticket-row">

                    <span>Nomor Kamar</span>

                    <strong><?= $dataKamar['nomor_kamar']; ?></strong>

                </div>

                <div class="ticket-row">

                    <span>Check In</span>

                    <strong>
                        <?= date('d M Y', strtotime($data['check_in'])); ?>
                    </strong>

                </div>

                <div class="ticket-row">

                    <span>Check Out</span>

                    <strong>
                        <?= date('d M Y', strtotime($data['check_out'])); ?>
                    </strong>

                </div>

                <div class="ticket-row">

                    <span>Total Bayar</span>

                    <strong>
                        Rp <?= number_format($total_bayar,0,',','.'); ?>
                    </strong>

                </div>

                <div class="ticket-row">

                    <span>Status Pembayaran</span>

                    <strong class="text-success">
                        <?= strtoupper($status_bayar); ?>
                    </strong>

                </div>

                <div class="ticket-row">

                    <span>Metode Pembayaran</span>

                    <strong>
                        <?= $metode_bayar; ?>
                    </strong>

                </div>

            </div>

            <div class="ticket-alert">

                <i class="fa-solid fa-info-circle"></i>

                Silakan tunjukkan tiket ini kepada resepsionis saat check in.

            </div>

            <button
                onclick="window.print()"
                class="btn-ticket-print">

                <i class="fa-solid fa-print"></i>

                Cetak Tiket

            </button>

            <a
                href="pengunjung.php"
                class="btn-ticket-back">

                <i class="fa-solid fa-arrow-left"></i>

                Kembali

            </a>

        </div>

    </div>

</body>

</html>