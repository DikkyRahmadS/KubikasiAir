<?php
include "koneksi.php"; // Include your database connection file

// Check if id_tarif is set and is a valid integer
if (isset($_GET['id_tarif']) && is_numeric($_GET['id_tarif'])) {
    $id_tarif = $_GET['id_tarif'];

    // Fetch data from database based on id_tarif
    $query = "SELECT * FROM tarif_dasar_air WHERE id_tarif = $id_tarif";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $nama_kelas = $row['nama_kelas'];
        $tarif_per_meter = $row['tarif_per_meter'];
    } else {
        echo "Data tarif tidak ditemukan.";
        exit;
    }
} else {
    echo "Invalid id_tarif.";
    exit;
}

// Process form submission for updating tarif
if (isset($_POST['update'])) {
    $id_tarif = $_POST['id_tarif'];
    $nama_kelas = $_POST['nama_kelas'];
    $tarif_per_meter = $_POST['tarif_per_meter'];

    // Example SQL query to update data in `tarif_dasar_air` table
    $sql = "UPDATE tarif_dasar_air SET nama_kelas = '$nama_kelas', tarif_per_meter = '$tarif_per_meter' WHERE id_tarif = $id_tarif";

    // Execute query
    $result = mysqli_query($koneksi, $sql);

    if ($result) {
        echo '<script>window.location.href = "index.php?page=tarif&success_update=1";</script>';
    } else {
        echo '<div class="alert"><span class="closebtn">&times;</span> <strong>Gagal!</strong> Update Data.</div>';
    }
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
                    <div class="d-flex mb-2">
                        <span class="fs-2hx fw-bolder text-gray-800 me-2 lh-1 ls-n2">Tarif Dasar Air</span>
                    </div>
                </div>
                <!--end::Statistics-->
                <!--begin::Chart-->
                <div class="min-h-auto ps-4 pe-6">
                    <!-- Form -->
                    <form action="#" method="POST">
                        <input type="hidden" name="id_tarif" value="<?php echo $id_tarif; ?>">
                        <div class="row mb-10">
                            <div class="col">
                                <div class="form-group">
                                    <label for="nama_kelas">Nama Kelas</label>
                                    <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" value="<?php echo $nama_kelas; ?>" placeholder="Masukkan Nama Kelas" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="tarif_per_meter">Tarif per Meter</label>
                                    <input type="number" step="any" class="form-control" id="tarif_per_meter" name="tarif_per_meter" value="<?php echo $tarif_per_meter; ?>" placeholder="Masukkan Tarif per Meter" required>
                                </div>
                            </div>
                        </div>
                        <center>
                            <button type="submit" name="update" class="btn btn-primary mb-5">Ubah</button>
                            <a href="index.php?page=tarif" class="btn btn-secondary mb-5">Kembali</a>
                        </center>

                    </form>
                    <!-- End Form -->
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