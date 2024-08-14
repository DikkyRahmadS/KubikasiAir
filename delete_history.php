<?php
include 'koneksi.php';
// sql to delete a record
$sql = "DELETE FROM transaksi_bayar";

if ($koneksi->query($sql) === TRUE) {
    header("location:index.php?page=history&hapus=1");
} else {
    echo "Error deleting record: " . $koneksi->error;
}
