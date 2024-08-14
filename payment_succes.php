<?php
include "koneksi.php";
$id_transaksi = $_GET['id_transaksi'];

//Update pembayaran
$sql = "UPDATE transaksi_bayar SET status='2' WHERE id_transaksi='$id_transaksi' ";
if ($koneksi->query($sql) === TRUE) {
  // Ambil meter_harian_id dari transaksi_bayar
  $sql_select_meter = "SELECT alat_meter FROM transaksi_bayar WHERE id_transaksi='$id_transaksi'";
  $result_meter = $koneksi->query($sql_select_meter);

  if ($result_meter->num_rows > 0) {
    // Ambil data meter_harian_id
    $row = $result_meter->fetch_assoc();
    $alat_meter = $row['alat_meter'];

    // Update status di tabel meter_harian
    $sql_update_meter = "UPDATE meter_harian SET status='1' WHERE id_alat='$alat_meter'";
    if ($koneksi->query($sql_update_meter) !== TRUE) {
      echo "Gagal mengupdate tabel meter_harian: " . $koneksi->error;
    }
  } else {
    echo "Tidak ada data meter_harian_id yang ditemukan untuk id_transaksi: " . $id_transaksi;
  }

  echo "<script>
    window.location='index_user.php?page=pembayaran';
    </script>";
} else {
  echo "Gagal!: " . $sql . "<br>" . $koneksi->error;
}

?>

<!doctype html>
<html lang="en" class="semi-dark">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--plugins-->
  <link rel="stylesheet" href="assets/css/style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

  <title></title>
</head>

<body>
  <div class="container">
    <div class="form-box box">
      <header>Terimakasih</header>
      <hr>
      <center>
        <p>Pembayaran berhasil! Silahkan cek detail pembayaran anda</p>

        <div class="mt-3"> <a href="index_user.php?page=pembayaran" class="btn btn-primary radius-15">Ke Riwayat</a>
      </center>
    </div>
  </div>


</body>

</html>