<?php
session_start();

if(!isset($_SESSION['login'])){
    header('location:login.php');
    exit;
}

include 'koneksi.php';
include 'template/header.php';
include 'template/sidebar.php';

$pendapatan_query = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT SUM(total_bayar) as total FROM transaksi
"))['total'];

$pendapatan_total = $pendapatan_query
    ? "Rp. " . number_format($pendapatan_query, 0, ',', '.')
    : "Rp. 0";

$jumlah_transaksi = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) as total FROM transaksi WHERE status_bayar = 'lunas'
"))['total'];

$jumlah_tamu = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) as total FROM tamu
"))['total'];
?>

<div class="content">

<h2>Laporan Hotel</h2>

<div class="row mb-4">

    <div class="col-md-4">
        <div class="card-box">
            <h4>Total Pendapatan</h4>
            <h2><?= $pendapatan_total; ?></h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-box">
            <h4>Transaksi Lunas</h4>
            <h2><?= $jumlah_transaksi; ?></h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-box">
            <h4>Total Tamu</h4>
            <h2><?= $jumlah_tamu; ?></h2>
        </div>
    </div>

</div>

<div class="card p-4">

    <h5 class="mb-3">Riwayat Transaksi</h5>

    <table class="table table-bordered table-striped bg-white">

        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tamu</th>
                <th>Kamar</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Total Bayar</th>
                <th>Metode</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>

        <?php
        $no = 1;
        $laporan_query = mysqli_query($conn, "
            SELECT tr.*, t.nama, t.kamar, t.check_in, t.check_out
            FROM transaksi tr
            JOIN reservasi r ON tr.id_reservasi = r.id_reservasi
            JOIN tamu t ON r.id_tamu = t.id_tamu
            ORDER BY tr.id_transaksi DESC
        ");

        if(mysqli_num_rows($laporan_query) > 0){
            while($row = mysqli_fetch_array($laporan_query)){
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['kamar']; ?></td>
                <td><?= $row['check_in']; ?></td>
                <td><?= $row['check_out']; ?></td>
                <td>Rp. <?= number_format($row['total_bayar'], 0, ',', '.'); ?></td>
                <td><?= $row['metode_bayar']; ?></td>
                <td>
                    <span class="badge bg-<?= $row['status_bayar'] == 'lunas' ? 'success' : 'warning'; ?>">
                        <?= ucfirst($row['status_bayar']); ?>
                    </span>
                </td>
            </tr>
        <?php
            }
        } else {
        ?>
            <tr>
                <td colspan="8" class="text-center text-muted">Belum ada data transaksi</td>
            </tr>
        <?php } ?>

        </tbody>

    </table>

</div>

</div>

<?php include 'template/footer.php'; ?>
