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
                        <?php

                        include "koneksi.php"; // Include your database connection file

                        if (isset($_POST['simpan'])) {
                            $nama_kelas = $_POST['nama_kelas'];
                            $tarif_per_meter = $_POST['tarif_per_meter'];

                            // Perform validation if necessary

                            // Example SQL query to insert data into `tarif_dasar_air` table
                            $sql = "INSERT INTO tarif_dasar_air (nama_kelas, tarif_per_meter) VALUES ('$nama_kelas', '$tarif_per_meter')";

                            // Execute query
                            $result = mysqli_query($koneksi, $sql);

                            if ($result) {
                                echo '<script>window.location.href = "index.php?page=tarif&success=1";</script>';
                            } else {
                                echo '<div class="alert"><span class="closebtn">&times;</span> <strong>Gagal!</strong> Menyimpan Data.</div>';
                            }
                        }
                        ?>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="nama_kelas" class="form-label">Nama Kelas</label>
                                    <input type="text" class="form-control" id="nama_kelas" placeholder="Masukkan Nama Kelas" name="nama_kelas">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-10">
                                    <label for="tarif_per_meter" class="form-label">Tarif per Meter</label>
                                    <input type="number" step="any" class="form-control" id="tarif_per_meter" placeholder="Masukkan Tarif per Meter" name="tarif_per_meter" required>
                                </div>
                            </div>
                        </div>
                        <center>
                            <button type="submit" name="simpan" class="btn btn-primary mb-5">Simpan</button>
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