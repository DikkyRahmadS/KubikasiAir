<?php
$page = (isset($_GET['page'])) ? $_GET['page'] : '';
switch ($page) {
    case 'check':
        include "content/check_pemakaian.php";
        break;
    case 'pembayaran':
        include "content/pembayaran.php";
        break;



    default: // Ini untuk set default jika isi dari $page tidak ada pada 2 kondisi diatas
        echo "Halaman Tidak Ada";
}
