<div class="row g-5 g-xl-12 mb-xl-12">
    <!--begin::Col-->
    <div class="col-lg-12 col-xl-12 col-xxl-12 mb-5 mb-xl-5">
        <!--begin::Chart widget 3-->
        <div class="card card-flush overflow-hidden h-md-100">

            <!-- PHP Alert for Successful Deletion -->
            <?php
            if (isset($_GET['hapus']) && $_GET['hapus'] == 1) {
                echo '<div class="alert success"><span class="closebtn">&times;</span>  <strong>Berhasil!</strong> Data berhasil dihapus</div>';
            }
            ?>

            <!-- Card body -->
            <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
                <!-- Statistics and Filters -->
                <div class="px-9 mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-2 col">
                        <div class="row">
                            <span class="fs-2hx fw-bolder text-gray-800 me-2 lh-1 ls-n2">Data History Transaksi</span>
                        </div>
                        <div class="row">
                            <!-- Form for Month and Year Filters -->
                            <form method="GET" action="index.php?page=history">
                                <div class="row">
                                    <div class="col p-0">
                                        <select class="form-select form-select-sm " name="bulan">
                                            <option value="">Bulan</option>
                                            <?php
                                            $bulan = date('m');
                                            $months = [
                                                '01' => 'Januari',
                                                '02' => 'Februari',
                                                '03' => 'Maret',
                                                '04' => 'April',
                                                '05' => 'Mei',
                                                '06' => 'Juni',
                                                '07' => 'Juli',
                                                '08' => 'Agustus',
                                                '09' => 'September',
                                                '10' => 'Oktober',
                                                '11' => 'November',
                                                '12' => 'Desember'
                                            ];
                                            foreach ($months as $key => $value) {
                                                echo '<option value="' . $key . '"';
                                                if (isset($_GET['bulan']) && $_GET['bulan'] == $key) echo ' selected';
                                                echo '>' . $value . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col ">
                                        <select class="form-select form-select-sm " name="tahun">
                                            <option value="">Tahun</option>
                                            <?php
                                            $tahun = date('Y');
                                            for ($i = $tahun; $i >= $tahun - 10; $i--) {
                                                echo '<option value="' . $i . '"';
                                                if (isset($_GET['tahun']) && $_GET['tahun'] == $i) echo ' selected';
                                                echo '>' . $i . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col ">
                                        <button type="submit" class="btn btn-success btn-sm">Filter</button>
                                    </div>
                                    <input type="hidden" name="page" value="history">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Table of Transactions -->
                <div class="min-h-auto ps-4 pe-6">
                    <div class="single-table">
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead class="text-uppercase bg-primary">
                                    <tr class="text-white">
                                        <th scope="col">ID Transaksi</th>
                                        <th scope="col">ID Alat</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Meter Pemakaian</th>
                                        <th scope="col">Total Bayar</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $where_clause = '';
                                    if (isset($_GET['bulan']) && $_GET['bulan'] != '' && isset($_GET['tahun']) && $_GET['tahun'] != '') {
                                        $bulan = $_GET['bulan'];
                                        $tahun = $_GET['tahun'];
                                        $where_clause = "WHERE MONTH(tgl_bayar) = '$bulan' AND YEAR(tgl_bayar) = '$tahun'";
                                    } elseif (isset($_GET['bulan']) && $_GET['bulan'] != '') {
                                        $bulan = $_GET['bulan'];
                                        $where_clause = "WHERE MONTH(tgl_bayar) = '$bulan'";
                                    } elseif (isset($_GET['tahun']) && $_GET['tahun'] != '') {
                                        $tahun = $_GET['tahun'];
                                        $where_clause = "WHERE YEAR(tgl_bayar) = '$tahun'";
                                    }


                                    $sql = mysqli_query($koneksi, "SELECT * FROM transaksi_bayar $where_clause ORDER BY id_transaksi ASC ");

                                    if (mysqli_num_rows($sql) == 0) {
                                        echo '<tr><td colspan="5">Tidak ada data.</td></tr>';
                                    } else {
                                        $no = 1;
                                        while ($row = mysqli_fetch_assoc($sql)) {
                                            // Mengatur teks status berdasarkan nilai dalam database
                                            $status_text = '';
                                            if ($row['status'] == 1) {
                                                $status_text = 'Pending';
                                            } elseif ($row['status'] == 2) {
                                                $status_text = 'Pembayaran Berhasil';
                                            } else {
                                                $status_text = 'Pembayaran Gagal'; // Tambahkan default jika ada nilai status lainnya
                                            }
                                            // Membuat baris tabel dengan data yang telah diubah
                                            echo '
                                                    <tr> 
                                                        <td><center>' . $row['id_transaksi'] . '</td>
                                                        <td><center>' . $row['alat_meter'] . '</td>
                                                        <td><center>' . $row['tgl_bayar'] . '</td>
                                                        <td><center>' . $row['meter_pemakaian'] . ' m³</td>
                                                        <td><center>Rp. ' . number_format($row['total_bayar'], 2) . '</td>
                                                        <td><center>' . $status_text . '</td>
                                                    </tr>
                                                ';
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- Clear All Button -->
                        <?php
                        if (mysqli_num_rows($sql) == 0) {
                        } else {
                        ?>
                            <center></br><a onclick="return confirm('Apakah Anda yakin ingin menghapus semua data ini?')" href="delete_history.php" class="btn btn-danger mx-auto mx-md-0 text-white mb-5">Clear All</a></center>
                        <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
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