<?php
include 'koneksi.php';
// sql to delete a record
$id = $_GET['id'];
$sql = "DELETE FROM users where id = $id";

if ($koneksi->query($sql) === TRUE) {
    header("location:index.php?page=pelanggan&hapus=1");
} else {
    echo "Error deleting record: " . $koneksi->error;
}
