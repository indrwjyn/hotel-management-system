<?php

session_start();

include 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header('location:login.php');
    exit;
}

if (isset($_POST['tambah'])) {

    $nama      = $_POST['nama'];
    $hp        = $_POST['hp'];
    $kamar     = $_POST['kamar'];
    $alamat    = $_POST['alamat'];
    $check_in  = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    $stmt = mysqli_prepare($conn, "INSERT INTO tamu (nama, hp, kamar, alamat, check_in, check_out) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssssss', $nama, $hp, $kamar, $alamat, $check_in, $check_out);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

if (isset($_POST['update'])) {

    $id     = $_POST['id'];
    $nama   = $_POST['nama'];
    $hp     = $_POST['hp'];
    $alamat = $_POST['alamat'];

    $stmt = mysqli_prepare($conn, "UPDATE tamu SET nama = ?, hp = ?, alamat = ? WHERE id_tamu = ?");
    mysqli_stmt_bind_param($stmt, 'sssi', $nama, $hp, $alamat, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

if (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    $stmt = mysqli_prepare($conn, "DELETE FROM tamu WHERE id_tamu = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

include 'template/header.php';
include 'template/sidebar.php';

?>

<div class="content p-4">

    <h2 class="mb-4">Data Tamu</h2>

    <div class="card p-4 mb-4">

        <form method="POST">

            <div class="row mb-3">

                <div class="col-md-6">

                    <label>Nama Tamu</label>

                    <input
                        type="text"
                        name="nama"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-6">

                    <label>No HP</label>

                    <input
                        type="text"
                        name="hp"
                        class="form-control"
                        required>

                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-6">

                    <label>Kamar</label>

                    <input
                        type="text"
                        name="kamar"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-6">

                    <label>Alamat</label>

                    <textarea
                        name="alamat"
                        class="form-control"></textarea>

                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-6">

                    <label>Check In</label>

                    <input
                        type="date"
                        name="check_in"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-6">

                    <label>Check Out</label>

                    <input
                        type="date"
                        name="check_out"
                        class="form-control"
                        required>

                </div>

            </div>

            <button
                type="submit"
                name="tambah"
                class="btn btn-primary">

                Tambah Data

            </button>

        </form>

    </div>

    <div class="card p-4">

        <table class="table table-bordered table-striped bg-white">

            <tr>

                <th>No</th>
                <th>Nama</th>
                <th>No HP</th>
                <th>Kamar</th>
                <th>Alamat</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Aksi</th>

            </tr>

            <?php

            $no = 1;

            $query = mysqli_query($conn, "

                SELECT * FROM tamu
                ORDER BY id_tamu DESC

            ");

            while ($data = mysqli_fetch_array($query)) {

            ?>

                <tr>

                    <td><?= $no++; ?></td>
                    <td><?= $data['nama']; ?></td>
                    <td><?= $data['hp']; ?></td>
                    <td><?= $data['kamar']; ?></td>
                    <td><?= $data['alamat']; ?></td>
                    <td><?= $data['check_in']; ?></td>
                    <td><?= $data['check_out']; ?></td>

                    <td>

                        <button
                            type="button"
                            class="btn btn-warning btn-sm mb-1"
                            onclick="bukaModalEdit(
                                '<?= $data['id_tamu']; ?>',
                                '<?= addslashes($data['nama']); ?>',
                                '<?= addslashes($data['hp']); ?>',
                                '<?= addslashes($data['kamar']); ?>',
                                '<?= addslashes($data['alamat']); ?>',
                                '<?= $data['check_in']; ?>',
                                '<?= $data['check_out']; ?>'
                            )">

                            Edit

                        </button>

                        <a
                            href="?hapus=<?= $data['id_tamu']; ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus data ini?')">

                            Hapus

                        </a>

                    </td>

                </tr>

            <?php } ?>

        </table>

    </div>

</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">Edit Data Tamu</h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form method="POST">

                <div class="modal-body">

                    <input type="hidden" name="id" id="edit_id">

                    <div class="row mb-3">

                        <div class="col-md-6">

                            <label>Nama Tamu</label>

                            <input
                                type="text"
                                name="nama"
                                id="edit_nama"
                                class="form-control"
                                required>

                        </div>

                        <div class="col-md-6">

                            <label>No HP</label>

                            <input
                                type="text"
                                name="hp"
                                id="edit_hp"
                                class="form-control"
                                required>

                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-md-6">

                            <label>Kamar</label>

                            <input
                                type="text"
                                id="edit_kamar"
                                class="form-control"
                                readonly>

                            <small class="text-muted">
                                Kamar tidak dapat diubah setelah pemesanan dibuat.
                            </small>

                        </div>

                        <div class="col-md-6">

                            <label>Alamat</label>

                            <textarea
                                name="alamat"
                                id="edit_alamat"
                                class="form-control"></textarea>

                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-md-6">

                            <label>Check In</label>

                            <input
                                type="date"
                                id="edit_check_in"
                                class="form-control"
                                readonly>

                            <small class="text-muted">
                                Tanggal check in tidak dapat diubah.
                            </small>

                        </div>

                        <div class="col-md-6">

                            <label>Check Out</label>

                            <input
                                type="date"
                                id="edit_check_out"
                                class="form-control"
                                readonly>

                            <small class="text-muted">
                                Tanggal check out tidak dapat diubah.
                            </small>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button
                        type="submit"
                        name="update"
                        class="btn btn-warning">

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

function bukaModalEdit(id, nama, hp, kamar, alamat, check_in, check_out) {

    document.getElementById('edit_id').value         = id;
    document.getElementById('edit_nama').value       = nama;
    document.getElementById('edit_hp').value         = hp;
    document.getElementById('edit_kamar').value      = kamar;
    document.getElementById('edit_alamat').value     = alamat;
    document.getElementById('edit_check_in').value   = check_in;
    document.getElementById('edit_check_out').value  = check_out;

    var modal = new bootstrap.Modal(document.getElementById('modalEdit'));
    modal.show();
}

</script>

<?php include 'template/footer.php'; ?>