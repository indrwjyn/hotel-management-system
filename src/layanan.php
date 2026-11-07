<?php
include 'template/auth.php';
include 'koneksi.php'; 
include 'template/header.php';
include 'template/sidebar.php';
?>

<div class="content">
    <h2>Layanan Hotel</h2>
    <ul class="list-group">
        <?php
        $layanan_query = mysqli_query($conn, "SELECT * FROM layanan");
        while($data = mysqli_fetch_array($layanan_query)){
        ?>
        <li class="list-group-item">
            <?= $data['nama_layanan']; ?> - Rp. <?= number_format($data['harga'], 0, ',', '.'); ?>
        </li>
        <?php } ?>
    </ul>
</div>

<?php include 'template/footer.php'; ?>