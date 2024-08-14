<?php
$page = (isset($_GET['page'])) ? $_GET['page'] : '';
switch ($page) {
    case 'tarif':
        include "content/data_tarif.php";
        break;
    case 'input_tarif':
        include "content/tarif_dasar_air.php";
        break;
    case 'update_tarif':
        include "content/update_tarif.php";
        break;
    case 'pelanggan':
        include "content/data_pelanggan.php";
        break;
    case 'input_pelanggan':
        include "content/pelanggan.php";
        break;
    case 'update_pelanggan':
        include "content/update_pelanggan.php";
        break;
    case 'history':
        include "content/history.php";
        break;



    default: // Ini untuk set default jika isi dari $page tidak ada pada  kondisi diatas
        echo "Halaman Tidak Ada";
}
