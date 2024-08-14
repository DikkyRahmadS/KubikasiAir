<?php
include 'koneksi.php';
// sql to delete a record
$id_tarif = $_GET['id_tarif'];
$sql = "DELETE FROM tarif_dasar_air where id_tarif = $id_tarif";

if ($koneksi->query($sql) === TRUE) {
    header("location:index.php?page=tarif&hapus=1");
} else {
    echo "Error deleting record: " . $koneksi->error;
}
