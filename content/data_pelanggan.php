<?php
// Cek apakah ada parameter success dan nilainya adalah 1
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo '<div class="alert success"><span class="closebtn">&times;</span>  <strong>Berhasil!</strong> Menyimpan Data</div>';
}
if (isset($_GET['hapus']) && $_GET['hapus'] == 1) {
    echo '<div class="alert success"><span class="closebtn">&times;</span>  <strong>Berhasil!</strong> Data berhasil dihapus</div>';
}
if (isset($_GET['success_update']) && $_GET['success_update'] == 1) {
    echo '<div class="alert success"><span class="closebtn">&times;</span>  <strong>Berhasil!</strong> Data berhasil diubah</div>';
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
                    <div class="d-flex justify-content-between align-items-center mb-2 col">
                        <div class="row">
                            <span class="fs-2hx fw-bolder text-gray-800 me-2 lh-1 ls-n2">Data Akun</span>
                        </div>
                        <div class="row">
                            <a href="index.php?page=input_pelanggan" class="btn btn-success">Tambah Data</a>
                        </div>
                    </div>
                </div>

                <!--end::Statistics-->
                <!--begin::Chart-->
                <div class="min-h-auto ps-4 pe-6">
                    <div class="single-table">
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead class="text-uppercase bg-primary">
                                    <tr class="text-white">
                                        <th scope="col">No</th>
                                        <th scope="col">Nama </th>
                                        <th scope="col">Kota </th>
                                        <th scope="col">No Telp</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">ID Alat </th>
                                        <th scope="col">Tarif</th>
                                        <th scope="col">Level </th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = mysqli_query($koneksi, "SELECT * FROM users INNER JOIN tarif_dasar_air ON users.id_tarif = tarif_dasar_air.id_tarif ORDER BY users.id_tarif ASC; ");

                                    if (mysqli_num_rows($sql) == 0) {
                                        echo '<tr><td colspan="4">No data record.</td></tr>'; // jika tidak ada entri di database maka tampilkan 'Data Tidak Ada.'
                                    } else { // jika terdapat entri maka tampilkan datanya
                                        $no = 1; // variabel untuk nomor urutan
                                        while ($row = mysqli_fetch_assoc($sql)) { // fetch query yang sesuai ke dalam array
                                            echo '
                                                <tr> 
                                                    <td><center>' . $no . '</td>
                                                    <td><center>' . $row['nama'] . '</td>
                                                    <td><center>' . $row['kota'] . '</td>
                                                    <td><center>' . $row['telp'] . '</td>
                                                    <td><center>' . $row['email'] . '</td>
                                                    <td><center>' . ($row['id_alat'] ? $row['id_alat'] : '<span class="text-danger">Tidak ada Alat</span>') . '</td>
                                                    <td><center>' . $row['nama_kelas'] . '</td>
                                                    <td><center>' . $row['level'] . '</td>
                                                    <td><center><a href="delete_pelanggan.php?id=' . $row['id'] . '" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')"  class="btn btn-danger mx-auto mx-md-0 text-white">Hapus</a>
                                                    <a  href="index.php?page=update_pelanggan&id=' . $row['id'] . '" class="btn btn-warning mx-auto mx-md-0 text-white">Ubah</a>
                                                    </td>
                                                </tr>
                                                ';
                                            $no++; // increment nomor urutan untuk baris selanjutnya
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
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

<script>
    var close = document.getElementsByClassName("closebtn");
    var i;

    for (i = 0; i < close.length; i++) {
        close[i].onclick = function() {
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function() {
                div.style.display = "none";
            }, 600);
        }
    }
</script>