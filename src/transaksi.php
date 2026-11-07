<?php
session_start();

if(!isset($_SESSION['login'])){
    header('location:login.php');
    exit;
}

include 'koneksi.php';
include 'template/header.php';
include 'template/sidebar.php';
?>

<div class="content">

<h2 class="mb-4">Transaksi</h2>

<div class="card p-4">

    <table class="table table-bordered table-striped bg-white">

        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tamu</th>
                <th>Kamar</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Tanggal Bayar</th>
                <th>Metode Bayar</th>
                <th>Total Bayar</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>

        <?php
        $no = 1;

        // Tampilkan semua tamu sebagai data booking, join dengan transaksi jika ada
        $query = mysqli_query($conn, "
            SELECT
                t.id_tamu,
                t.nama,
                t.kamar,
                t.check_in,
                t.check_out,
                tr.tanggal_bayar,
                tr.metode_bayar,
                tr.total_bayar,
                tr.status_bayar
            FROM tamu t
            LEFT JOIN reservasi r ON r.id_tamu = t.id_tamu
            LEFT JOIN transaksi tr ON tr.id_reservasi = r.id_reservasi
            ORDER BY t.id_tamu DESC
        ");

        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['kamar']; ?></td>
                <td><?= $row['check_in']; ?></td>
                <td><?= $row['check_out']; ?></td>
                <td><?= $row['tanggal_bayar'] ? $row['tanggal_bayar'] : '-'; ?></td>
                <td><?= $row['metode_bayar'] ? $row['metode_bayar'] : '-'; ?></td>
                <td>
                    <?= $row['total_bayar']
                        ? "Rp. " . number_format($row['total_bayar'], 0, ',', '.')
                        : '-';
                    ?>
                </td>
                <td>
                    <?php if($row['status_bayar']): ?>
                        <span class="badge bg-<?= $row['status_bayar'] == 'lunas' ? 'success' : 'warning'; ?>">
                            <?= ucfirst($row['status_bayar']); ?>
                        </span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Booking</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php
            }
        } else {
        ?>
            <tr>
                <td colspan="9" class="text-center text-muted">Belum ada data transaksi</td>
            </tr>
        <?php } ?>

        </tbody>

    </table>

</div>

</div>

<?php include 'template/footer.php'; ?>
