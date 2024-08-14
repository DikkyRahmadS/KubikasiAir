<?php
//DB
require("koneksi.php");

//Ambil id
$id_transaksi = $_GET['id_transaksi'];

//Hapus id
$sql = "DELETE FROM transaksi_bayar WHERE id_transaksi = '$id_transaksi'";
if ($koneksi->query($sql) === TRUE) {
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
  <link rel="stylesheet" href="assets/css/style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

  <title></title>
</head>

<body>
  <div class="container">
    <div class="form-box box">
      <header>Gagal</header>
      <hr>
      <center>
        <p>Pembayaran tidak berhasil. Silahkan melakukan pembayaran ulang atau menghubungi kami</p>

        <div class="mt-3"> <a href="index_user.php?page=pembayaran" class="btn btn-primary radius-15">Kembali</a>
      </center>
    </div>
  </div>

</body>

</html>