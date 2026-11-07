console.log("Hotel Management System");

const kamarRadio = document.querySelectorAll('input[name="kamar"]');

const hargaKamar = document.getElementById('hargaKamar');

const checkIn = document.querySelector('input[name="check_in"]');

const checkOut = document.querySelector('input[name="check_out"]');



function hitungHarga(){

    let hargaPerMalam = 300000;



    // =========================
    // CEK TIPE KAMAR
    // =========================

    kamarRadio.forEach(function(radio){

        if(radio.checked){

            if(radio.value == "Standard Room"){

                hargaPerMalam = 300000;

            }

            else if(radio.value == "Deluxe Room"){

                hargaPerMalam = 500000;

            }

            else if(radio.value == "Suite Room"){

                hargaPerMalam = 800000;

            }

        }

    });



    // =========================
    // HITUNG SELISIH HARI
    // =========================

    let tanggalMasuk = new Date(checkIn.value);

    let tanggalKeluar = new Date(checkOut.value);

    let selisih = tanggalKeluar - tanggalMasuk;

    let hari = selisih / (1000 * 60 * 60 * 24);



    // =========================
    // MINIMAL 1 HARI
    // =========================

    if(hari <= 0 || isNaN(hari)){

        hari = 1;

    }



    // =========================
    // TOTAL BAYAR
    // =========================

    let total = hargaPerMalam * hari;



    // =========================
    // FORMAT RUPIAH
    // =========================

    hargaKamar.innerHTML = "Rp " + total.toLocaleString('id-ID');

}



// =========================
// EVENT LISTENER
// =========================

kamarRadio.forEach(function(radio){

    radio.addEventListener('change', hitungHarga);

});

checkIn.addEventListener('change', hitungHarga);

checkOut.addEventListener('change', hitungHarga);



// =========================
// JALANKAN PERTAMA KALI
// =========================

hitungHarga();