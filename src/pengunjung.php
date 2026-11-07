<?php
include 'koneksi.php';

if(isset($_POST['pesan'])){

    $nama      = $_POST['nama'];
    $hp        = $_POST['hp'];
    $kamar     = $_POST['kamar'];
    $alamat    = $_POST['alamat'];
    $checkin   = $_POST['check_in'];
    $checkout  = $_POST['check_out'];

    $stmt = mysqli_prepare($conn, "INSERT INTO tamu (nama, hp, kamar, alamat, check_in, check_out) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssssss', $nama, $hp, $kamar, $alamat, $checkin, $checkout);
    $simpan = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if($simpan){

        $id_tamu = mysqli_insert_id($conn);

        header("location:tiket.php?id=$id_tamu");

    } else {

        echo "
        <script>
            alert('Gagal memesan kamar!');
        </script>
        ";

    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Booking Hotel</title>

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

    <div class="booking-container">

        <div class="booking-card">

            <div class="booking-header">

                <div class="booking-icon">

                    <i class="fa-solid fa-hotel"></i>

                </div>

                <h2>Booking Hotel</h2>

                <p>
                    Silakan isi data pemesanan kamar hotel
                </p>

            </div>

            <form method="POST">

                <!-- NAMA -->

                <div class="mb-3">

                    <label class="form-label">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="nama"
                        class="form-control booking-input"
                        placeholder="Masukkan nama lengkap"
                        required>

                </div>



                <!-- HP -->

                <div class="mb-3">

                    <label class="form-label">
                        Nomor HP
                    </label>

                    <input
                        type="text"
                        name="hp"
                        class="form-control booking-input"
                        placeholder="Masukkan nomor HP"
                        required>

                </div>



                <!-- ALAMAT -->

                <div class="mb-3">

                    <label class="form-label">
                        Alamat Lengkap
                    </label>

                    <textarea
                        name="alamat"
                        class="form-control booking-textarea"
                        placeholder="Masukkan alamat lengkap"
                        required></textarea>

                </div>



                <!-- PILIH KAMAR -->

                <div class="mb-4">

                    <label class="form-label">
                        Pilih Tipe Kamar
                    </label>

                    <div class="room-options">

                        <!-- STANDARD -->

                        <label class="room-card">

                            <input
                                type="radio"
                                name="kamar"
                                value="Standard Room"
                                checked>

                            <div class="room-content">

                                <i class="fa-solid fa-bed"></i>

                                <h5>Standard Room</h5>

                                <p>
                                    Nyaman untuk 2 orang
                                </p>

                            </div>

                        </label>



                        <!-- DELUXE -->

                        <label class="room-card deluxe">

                            <input
                                type="radio"
                                name="kamar"
                                value="Deluxe Room">

                            <div class="room-content">

                                <i class="fa-solid fa-crown"></i>

                                <h5>Deluxe Room</h5>

                                <p>
                                    Kamar premium & modern
                                </p>

                            </div>

                        </label>



                        <!-- SUITE -->

                        <label class="room-card suite">

                            <input
                                type="radio"
                                name="kamar"
                                value="Suite Room">

                            <div class="room-content">

                                <i class="fa-solid fa-gem"></i>

                                <h5>Suite Room</h5>

                                <p>
                                    Fasilitas mewah lengkap
                                </p>

                            </div>

                        </label>

                    </div>

                </div>



                <!-- TOTAL HARGA -->

                <div class="price-box">

                    <h5>
                        Total Harga
                    </h5>

                    <h2 id="hargaKamar">
                        Rp 300.000
                    </h2>

                </div>



                <!-- TANGGAL -->

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Check In
                        </label>

                        <input
                            type="date"
                            name="check_in"
                            class="form-control booking-input"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Check Out
                        </label>

                        <input
                            type="date"
                            name="check_out"
                            class="form-control booking-input"
                            required>

                    </div>

                </div>



                <!-- BUTTON -->

                <button
                    type="submit"
                    name="pesan"
                    class="btn-booking">

                    <i class="fa-solid fa-paper-plane"></i>

                    Pesan Sekarang

                </button>

            </form>



            <!-- KEMBALI -->

            <a
                href="login.php"
                class="btn-kembali">

                <i class="fa-solid fa-arrow-left"></i>

                Kembali ke Login

            </a>

        </div>

    </div>



    <!-- JS -->

    <script src="asset/js/script.js"></script>

</body>

</html>