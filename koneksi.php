<?php

$host = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "kubikasi_air"; 

$koneksi = new mysqli($host, $username, $password, $database);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// echo "Koneksi sukses";

// Query untuk mendapatkan data pendapatan tiap hari
// $query = "SELECT tanggal, pendapatan FROM data";
// $result = $koneksi->query($query);

// $data = array();

// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         $data[] = $row;
//     }
// }

// echo json_encode($data);

// $koneksi->close();