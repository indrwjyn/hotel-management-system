<?php
include 'template/auth.php';

include 'koneksi.php';
include 'template/header.php';
include 'template/sidebar.php';

/* tambah pegawai */

if(isset($_POST['tambah'])){

    $nama    = $_POST['nama_pegawai'];
    $jabatan = $_POST['jabatan'];
    $no_hp   = $_POST['no_hp'];
    $alamat  = $_POST['alamat'];

    $stmt = mysqli_prepare($conn, "INSERT INTO pegawai (nama_pegawai, jabatan, no_hp, alamat) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssss', $nama, $jabatan, $no_hp, $alamat);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

/* hapus pegawai */

if(isset($_GET['hapus'])){

    $id = $_GET['hapus'];

    $stmt = mysqli_prepare($conn, "DELETE FROM pegawai WHERE id_pegawai = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

?>

<div class="content p-4">

    <h2 class="mb-4">Data Pegawai</h2>

    <!-- form tambah pegawai -->

    <div class="card p-4 mb-4">

        <form method="POST">

            <div class="row mb-3">

                <div class="col-md-6">

                    <label>Nama Pegawai</label>

                    <input
                        type="text"
                        name="nama_pegawai"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-6">

                    <label>Jabatan</label>

                    <select
                        name="jabatan"
                        class="form-control"
                        required>

                        <option value="">-- Pilih Jabatan --</option>
                        <option value="magang">Magang</option>
                        <option value="tetap">Tetap</option>
                        <option value="supervisor">Supervisor</option>
                        <option value="manager">Manager</option>
                        <option value="stakeholder">Stakeholder</option>

                    </select>

                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-6">

                    <label>No HP</label>

                    <input
                        type="text"
                        name="no_hp"
                        class="form-control">

                </div>

                <div class="col-md-6">

                    <label>Alamat</label>

                    <textarea
                        name="alamat"
                        class="form-control"></textarea>

                </div>

            </div>

            <button
                type="submit"
                name="tambah"
                class="btn btn-primary">

                Tambah Pegawai

            </button>

        </form>

    </div>

    <!-- tabel pegawai -->

    <div class="card p-4">

        <table class="table table-bordered table-striped bg-white">

            <tr>

                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Jabatan</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>Aksi</th>

            </tr>

            <?php

            $no = 1;

            $pegawai_query = mysqli_query($conn, "

                SELECT * FROM pegawai
                ORDER BY id_pegawai DESC

            ");

            while($data = mysqli_fetch_array($pegawai_query)){

            ?>

            <tr>

                <td><?= $no++; ?></td>
                <td><?= $data['nama_pegawai']; ?></td>
                <td><?= $data['jabatan']; ?></td>
                <td><?= $data['no_hp']; ?></td>
                <td><?= $data['alamat']; ?></td>

                <td>

                    <a
                        href="?hapus=<?= $data['id_pegawai']; ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin ingin menghapus pegawai ini?')">

                        Hapus

                    </a>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

<?php include 'template/footer.php'; ?>