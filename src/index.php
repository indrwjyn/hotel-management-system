<?php
session_start();

if(!isset($_SESSION['login'])){
    header('location:login.php');
    exit;
}

include 'koneksi.php';
include 'template/header.php';
include 'template/sidebar.php';

$tamu_count = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) as total FROM tamu
"))['total'];

$kamar_count = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) as total FROM kamar
"))['total'];

$reservasi_count = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) as total FROM reservasi
"))['total'];

$pendapatan_query = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT SUM(total_bayar) as total FROM transaksi
"))['total'];

$pendapatan_total = $pendapatan_query
? "Rp. " . number_format($pendapatan_query, 0, ',', '.')
: "Rp. 0";
?>

<div class="content">

    <div class="dashboard-header">

        <div>

            <h2>
                Dashboard Hotel
            </h2>

            <p>
                Selamat datang di Sistem Management Hotel
            </p>

        </div>

        <div class="dashboard-badge">

            <i class="fa-solid fa-hotel"></i>

            Hotel Luxury

        </div>

    </div>

    <div class="row">

        <div class="col-md-3 mb-4">

            <div class="dashboard-card blue">

                <div>

                    <h5>Total Tamu</h5>

                    <h2><?= $tamu_count; ?></h2>

                </div>

                <div class="dashboard-icon">

                    <i class="fa-solid fa-users"></i>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="dashboard-card green">

                <div>

                    <h5>Jenis Kamar</h5>

                    <h2><?= $kamar_count; ?></h2>

                </div>

                <div class="dashboard-icon">

                    <i class="fa-solid fa-bed"></i>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="dashboard-card orange">

                <div>

                    <h5>Reservasi</h5>

                    <h2><?= $reservasi_count; ?></h2>

                </div>

                <div class="dashboard-icon">

                    <i class="fa-solid fa-calendar-check"></i>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="dashboard-card dark">

                <div>

                    <h5>Pendapatan</h5>

                    <h2><?= $pendapatan_total; ?></h2>

                </div>

                <div class="dashboard-icon">

                    <i class="fa-solid fa-wallet"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="activity-card">

        <div class="activity-header">

            <h4>
                Aktivitas Terbaru
            </h4>

            <span>
                5 Reservasi Terakhir
            </span>

        </div>

        <div class="table-responsive">

            <table class="table custom-table">

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Nama Tamu</th>
                        <th>Kamar</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    $no = 1;

                    $aktivitas_query = mysqli_query($conn, "
                    
                        SELECT * FROM tamu
                        ORDER BY id_tamu DESC
                        LIMIT 5
                    
                    ");

                    while($row = mysqli_fetch_array($aktivitas_query)){
                    ?>

                    <tr>

                        <td><?= $no++; ?></td>

                        <td><?= $row['nama']; ?></td>

                        <td><?= $row['kamar']; ?></td>

                        <td>

                            <span class="status-booking">

                                Booking

                            </span>

                        </td>

                    </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include 'template/footer.php'; ?>