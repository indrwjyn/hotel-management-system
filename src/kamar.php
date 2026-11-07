<?php
include 'template/auth.php';
include 'koneksi.php'; // Panggil koneksi database
include 'template/header.php';
include 'template/sidebar.php';
?>

<div class="content">
    <h2>Data Kamar</h2>

    <h4 class="mt-4 text-secondary">Standard Room</h4>
    <table class="table table-bordered bg-white mb-4">
        <tr class="table-light">
            <th>No</th>
            <th>Nomor Kamar</th>
            <th>Harga</th>
            <th>Status</th>
        </tr>
        <?php
        $no = 1;
        $kamar_standard = mysqli_query($conn, "SELECT * FROM kamar WHERE tipe_kamar='Standard Room'");
        while($data = mysqli_fetch_array($kamar_standard)){
            $badge_color = ($data['status_kamar'] == 'tersedia') ? 'bg-success' : 'bg-danger';
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['nomor_kamar']; ?></td>
            <td>Rp. <?= number_format($data['harga'], 0, ',', '.'); ?></td>
            <td>
                <span class="badge <?= $badge_color; ?>">
                    <?= ucfirst($data['status_kamar']); ?>
                </span>
            </td>
        </tr>
        <?php } ?>
    </table>

    <h4 class="mt-4 text-secondary">Deluxe Room</h4>
    <table class="table table-bordered bg-white mb-4">
        <tr class="table-light">
            <th>No</th>
            <th>Nomor Kamar</th>
            <th>Harga</th>
            <th>Status</th>
        </tr>
        <?php
        $no = 1;
        $kamar_deluxe = mysqli_query($conn, "SELECT * FROM kamar WHERE tipe_kamar='Deluxe Room'");
        while($data = mysqli_fetch_array($kamar_deluxe)){
            $badge_color = ($data['status_kamar'] == 'tersedia') ? 'bg-success' : 'bg-danger';
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['nomor_kamar']; ?></td>
            <td>Rp. <?= number_format($data['harga'], 0, ',', '.'); ?></td>
            <td>
                <span class="badge <?= $badge_color; ?>">
                    <?= ucfirst($data['status_kamar']); ?>
                </span>
            </td>
        </tr>
        <?php } ?>
    </table>

    <h4 class="mt-4 text-secondary">Suite Room</h4>
    <table class="table table-bordered bg-white mb-4">
        <tr class="table-light">
            <th>No</th>
            <th>Nomor Kamar</th>
            <th>Harga</th>
            <th>Status</th>
        </tr>
        <?php
        $no = 1;
        $kamar_suite = mysqli_query($conn, "SELECT * FROM kamar WHERE tipe_kamar='Suite Room'");
        while($data = mysqli_fetch_array($kamar_suite)){
            $badge_color = ($data['status_kamar'] == 'tersedia') ? 'bg-success' : 'bg-danger';
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['nomor_kamar']; ?></td>
            <td>Rp. <?= number_format($data['harga'], 0, ',', '.'); ?></td>
            <td>
                <span class="badge <?= $badge_color; ?>">
                    <?= ucfirst($data['status_kamar']); ?>
                </span>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<?php include 'template/footer.php'; ?>