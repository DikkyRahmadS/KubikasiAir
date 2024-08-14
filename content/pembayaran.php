<?php

use Infobip\Api\WhatsAppApi;
use Infobip\Configuration;
use Infobip\Model\WhatsAppTextMessage;
use Infobip\Model\WhatsAppTextContent;

require 'vendor/autoload.php';

$id = $_SESSION['id'];
$alat_id = $_SESSION['id_alat'];
$nama = $_SESSION['nama'];
$telp = $_SESSION['telp'];
$query_id_tarif = "SELECT id_tarif FROM users WHERE id='$id'";
$result_id_tarif = mysqli_query($koneksi, $query_id_tarif);

// Check if the query executed successfully
if ($result_id_tarif) {
    // Fetch the id_tarif from the result set
    $row_id_tarif = mysqli_fetch_assoc($result_id_tarif);
    $id_tarif = $row_id_tarif['id_tarif'];

    // Query to fetch meter_pemakaian using the fetched id_tarif
    $query_meter = "SELECT 
    id_alat,
    (SELECT MIN(meter_pemakaian) FROM meter_harian WHERE status = 0 AND id_alat = '$alat_id') AS min_meter_pemakaian,
    (SELECT MAX(meter_pemakaian) FROM meter_harian WHERE status = 0 AND id_alat = '$alat_id') AS max_meter_pemakaian
    FROM 
        meter_harian 
    WHERE 
        status = 0 AND 
        id_alat = '$alat_id' 
    LIMIT 1;
    ";
    $result_meter = mysqli_query($koneksi, $query_meter);

    $query_tarif = "SELECT tarif_per_meter FROM tarif_dasar_air WHERE id_tarif=$id_tarif";
    $result_tarif = mysqli_query($koneksi, $query_tarif);


    // Check if the query executed successfully
    if ($result_meter && $result_tarif) {
        // Fetch the meter_pemakaian from the result set
        $row_meter = mysqli_fetch_assoc($result_meter);
        if ($row_meter) {
            //Data
            $alat_meter = $row_meter['id_alat'];
            $min_meter_pemakaian = $row_meter['min_meter_pemakaian'];
            $max_meter_pemakaian = $row_meter['max_meter_pemakaian'];
        } else {
            // Set default values if no result
            $min_meter_pemakaian = $max_meter_pemakaian = $alat_meter  = null;
        }

        $total_meter_pemakaian = $max_meter_pemakaian - $min_meter_pemakaian;
        //echo $meter_pemakaian;

        $row_tarif = mysqli_fetch_assoc($result_tarif);
        $tarif_pemakaian = $row_tarif['tarif_per_meter'];

        // Calculate the nilai
        $nilai = $tarif_pemakaian * $total_meter_pemakaian;
    } else {
        // Handle query error for $query_meter
        echo "Error fetching meter_pemakaian: " . mysqli_error($koneksi);
    }
} else {
    // Handle query error for $query_id_tarif
    echo "Error fetching id_tarif: " . mysqli_error($koneksi);
}

$tampil = mysqli_query($koneksi, "SELECT * FROM transaksi_bayar  ORDER BY id_transaksi DESC LIMIT 1");
$hasilku = mysqli_fetch_array($tampil);
// Check if result is not null
if ($hasilku) {
    //Data
    $id_transaksi = $hasilku['id_transaksi'];
    $meter_pemakaian = $hasilku['meter_pemakaian'];
    $total_bayar = $hasilku['total_bayar'];
    $alat_meter = $hasilku['alat_meter'];
    $status = $hasilku['status'];
} else {
    // Set default values if no result
    $id_transaksi = $alat_meter = $meter_pemakaian  = $total_bayar = $status = null;
}

if (isset($_POST['bayar'])) {
    $total_bayar = $_POST['total_bayar'];
    $meter_pemakaian = $_POST['meter_pemakaian'];
    $alat_meter  =  $_SESSION['id_alat'];
    $tgl_bayar = date('Y-m-d H:i:s');
    $transaksi_id = rand();
    $status = 1;
    $sql = "INSERT INTO transaksi_bayar ( id_transaksi,tgl_bayar,meter_pemakaian, total_bayar,alat_meter, status)
            VALUES ('" . $transaksi_id . "','" . $tgl_bayar . "', '" . $meter_pemakaian . "','" . $total_bayar . "','" . $alat_meter . "', '" . $status . "')";
    if ($koneksi->query($sql) === TRUE) {
        //Lanjutkan ke pembayaran
        echo "<script>
               window.location='payment.php?id_transaksi=$transaksi_id&meter_pemakaian=$meter_pemakaian&total_bayar=$total_bayar&alat_meter=$alat_meter';
               </script>";
    } else {
        echo "Gagal!: " . $sql . "<br>" . $koneksi->error;
    }
}

date_default_timezone_set('Asia/Jakarta');
$jam_sekarang = date('H');

if ($jam_sekarang >= 0 && $jam_sekarang < 10) {
    $ucapan = "Selamat Pagi,";
} elseif ($jam_sekarang >= 10 && $jam_sekarang < 15) {
    $ucapan = "Selamat Siang,";
} elseif ($jam_sekarang >= 15 && $jam_sekarang < 18) {
    $ucapan = "Selamat Sore,";
} else {
    $ucapan = "Selamat Malam,";
}


$tanggal_sekarang = date('d');

if ($total_meter_pemakaian != NULL && $nilai != NULL && $tanggal_sekarang == 29) {
    $configuration = new Configuration(
        host: 'gg35q6.api.infobip.com',
        apiKey: '52d44c4c173f135e20265211645bdef1-957ab2f0-ae6c-403e-bc9b-7f4ca8597b2a'
    );
    $whatsAppApi = new WhatsAppApi(config: $configuration);

    $textMessage = new WhatsAppTextMessage(
        from: '447860099299',
        to: $telp,
        content: new WhatsAppTextContent(
            text: $ucapan . '

Yth. Sdr. ' . $nama . '

Kami informasikan bahwa total pemakaian air Anda untuk bulan ini mencapai  ' . $total_meter_pemakaian . ' m³ , dengan total tagihan sebesar  Rp.' . number_format($nilai, 2) . ' Kami mohon untuk segera melakukan pembayaran sesuai dengan jumlah tagihan tersebut sebelum tanggal jatuh tempo yang telah ditentukan.'
        )
    );

    $whatsAppApi = new WhatsAppApi(config: $configuration);

    $messageInfo = $whatsAppApi->sendWhatsAppTextMessage($textMessage);

    echo $messageInfo->getStatus()->getDescription() . PHP_EOL;
}



?>
<div class="row g-5 g-xl-12 mb-xl-12">
    <!--begin::Col-->
    <div class="col-lg-12 col-xl-12 col-xxl-12 mb-5 mb-xl-5">
        <!--begin::Chart widget 3-->
        <div class="card card-flush overflow-hidden h-md-100">

            <!--begin::Header-->
            <!--begin::Card body-->
            <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
                <!--begin::Statistics-->
                <div class="px-9 mb-5">
                    <!--begin::Statistics-->
                    <div class="d-flex mb-2">
                        <span class="fs-2hx fw-bolder text-gray-800 me-2 lh-1 ls-n2">Tagihan</span>
                    </div>
                </div>
                <!--end::Statistics-->
                <!--begin::Chart-->
                <div class="min-h-auto ps-4 pe-6">
                    <div class=" p-10 ">
                        <form method="post" action="#">
                            <input type="hidden" name="total_bayar" id="total_bayar" value="<?= $nilai ?>" required>
                            <input type="hidden" name="meter_pemakaian" id="meter_pemakaian" value="<?= $total_meter_pemakaian ?>" required>
                            <div class="row">
                                <div class="col">
                                    <label style="font-size: 30px;">Total Pemakaian</label>
                                    <h1 style="font-size: 56px;"> <?php echo isset($total_meter_pemakaian) ? $total_meter_pemakaian . ' m³' : '0 m³'; ?> </h1>
                                </div>
                                <div class="col">
                                    <label style="font-size: 30px;">Total Pembayaran</label>
                                    <h1 style="font-size: 56px;">Rp.<?php echo number_format($nilai, 2); ?> </h1>
                                </div>
                            </div>
                            <br>
                            <?php
                            if ($total_meter_pemakaian == NULL || $nilai == NULL) {
                            } else {
                            ?>
                                <center><button type="submit" name="bayar" class="btn btn-success">Bayar</button></center>
                            <?php
                            }
                            ?>
                        </form>
                    </div>
                </div>
                <!--end::Chart-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Chart widget 3-->
    </div>
    <!--end::Col-->

</div>