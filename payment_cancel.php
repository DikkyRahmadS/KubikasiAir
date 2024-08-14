<?php
//DB
require("koneksi.php");

//Ambil id
$id_transaksi = $_GET['id_transaksi'];

//Hapus id
$sql = "DELETE FROM transaksi_bayar WHERE id_transaksi = '$id_transaksi'";
if ($koneksi->query($sql) === TRUE) {
  //Berhasil
  echo "<script>
    window.location='index_user.php?page=pembayaran';
    </script>";
} else {
  echo "Gagal!: " . $sql . "<br>" . $koneksi->error;
}
