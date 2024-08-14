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
                        <span class="fs-2hx fw-bolder text-gray-800 me-2 lh-1 ls-n2">Input Data Pelanggan</span>
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
                            $nama = $_POST['nama'];
                            $alamat = $_POST['alamat'];
                            $kota = $_POST['kota'];
                            $email = $_POST['email'];
                            $pass = $_POST['password'];
                            $id_alat = $_POST['id_alat'];
                            $telp = $_POST['telp'];
                            $tarif = $_POST['tarif'];
                            $level = 'user';


                            $check = "select * from users where email='{$email}'";

                            $res = mysqli_query($koneksi, $check);

                            $passwd = password_hash($pass, PASSWORD_DEFAULT);

                            $key = bin2hex(random_bytes(12));

                            if (mysqli_num_rows($res) > 0) {
                                echo '<div class="alert"><span class="closebtn">&times;</span> <strong>Gagal!</strong> Email sudah digunakan, Silahkan coba sekali lagi!</div>';
                            } else {
                                $sql =
                                    "insert into users(nama,alamat,kota,telp,email,password,id_alat,id_tarif,level) values('$nama','$alamat','$kota','$telp','$email','$passwd','$id_alat','$tarif','$level')";

                                // Execute query
                                $result = mysqli_query($koneksi, $sql);

                                if ($result) {
                                    echo '<script>window.location.href = "index.php?page=pelanggan&success=1";</script>';
                                } else {
                                    echo '<div class="alert"><span class="closebtn">&times;</span> <strong>Gagal!</strong> Menyimpan Data!</div>';
                                }
                            }
                        }
                        ?>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Anda" name="nama">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="kota" class="form-label">Kota</label>
                                    <input type="text" class="form-control" id="kota" placeholder="Masukkan Kota Anda" name="kota">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea type="text" class="form-control" id="alamat" placeholder="Masukkan Alamat Anda" name="alamat" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email Anda" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Masukkan Password Anda" name="password" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="id_alat" class="form-label">ID Alat</label>
                            <input type="text" class="form-control" id="id_alat" name="id_alat" placeholder="Masukkan ID Alat Anda">
                        </div>
                        <div class="row mb-10">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="tarif" class="form-label">Tarif per Meter</label>
                                    <select class="form-control" name="tarif">
                                        <option value="">Pilih Tarif</option>
                                        <?php
                                        // Mengambil data dari tabel tarif_data_air
                                        $query_tarif = "SELECT * FROM tarif_dasar_air";
                                        $result_tarif = mysqli_query($koneksi, $query_tarif);

                                        // Loop untuk menampilkan data sebagai pilihan dropdown
                                        while ($row_tarif = mysqli_fetch_assoc($result_tarif)) {
                                            $id_tarif = $row_tarif['id_tarif'];
                                            $nama_kelas = $row_tarif['nama_kelas'];
                                            $tarif_per_meter = $row_tarif['tarif_per_meter'];
                                            echo "<option value='{$id_tarif}'>{$nama_kelas} - {$tarif_per_meter}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="telp" class="form-label">No Telephone</label>
                                    <input type="text" class="form-control" id="telp" placeholder="Masukkan No Telphone Anda" name="telp" required>
                                </div>
                            </div>
                        </div>
                        <center>
                            <button type="submit" name="simpan" class="btn btn-primary mb-5">Simpan</button>
                            <a href="index.php?page=pelanggan" class="btn btn-secondary mb-5">Kembali</a>
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