 <?php
    $alat_id = $_SESSION['id_alat'];
    $url = 'https://platform.antares.id:8443/~/antares-cse/antares-id/DRIVE_TEST_LORA/esp32-rf95/la';
    $access_token = 'b07f83b1409132e9:84c6cc0b97b86892';

    // Inisialisasi curl
    $ch = curl_init($url);

    // Set opsi curl
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Agar hasilnya langsung di-return sebagai string
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'X-M2M-Origin: ' . $access_token,
    ]);

    // Jalankan curl
    $response = curl_exec($ch);

    // Cek jika ada error
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    // Tutup curl
    curl_close($ch);

    // Decode JSON response
    $json_data = json_decode($response, true);

    // Ambil nilai ct dan data dari JSON
    if (isset($json_data['m2m:cin']['ct'])) {
        $ct_value = $json_data['m2m:cin']['ct'];
        // echo 'ct value: ' . $ct_value . '<br>';
        $timestamp = strtotime($ct_value);
        $formatted_date = date('Y-m-d H:i:s', $timestamp);
        // echo 'Formatted timestamp: ' . $formatted_date . '<br>';
    }

    if (isset($json_data['m2m:cin']['con'])) {
        $con_data = json_decode($json_data['m2m:cin']['con'], true);
        if (isset($con_data['data'])) {
            $data_value = $con_data['data'];
            // echo 'data value: ' . $data_value . '<br>';
            $meter_pemakaian_format = number_format($data_value, 0, ',', '.');
        }
        if (isset($con_data['devEui'])) {
            $devEui = $con_data['devEui'];
        }
    }


    $check = "select * from meter_harian where tanggal='{$formatted_date}' AND id_alat = '$alat_id'";

    $res = mysqli_query($koneksi, $check);
    if (mysqli_num_rows($res) > 0) {
        echo '<div class="alert warning"><span class="closebtn">&times;</span>  <strong>Tidak Ada Data Terbaru!</strong> Data Grafik Data Terbaru!</div>';
    } else {
        if ($_SESSION['id_alat'] == $devEui) {
            $sql_status = "select * from meter_harian where status=1";

            $cek_status = mysqli_query($koneksi, $sql_status);
            if (mysqli_num_rows($cek_status) > 0) {
                echo '<div class="alert warning"><span class="closebtn">&times;</span>  <strong>Tidak Ada Data Terbaru!</strong> Data Grafik Data Terbaru!</div>';
            } else {
                $sql = "insert into meter_harian(tanggal,meter_pemakaian,id_alat,status) values('$formatted_date','$meter_pemakaian_format','$devEui',0)";

                $result = mysqli_query($koneksi, $sql);
            }
        } else {
            echo '<div class="alert warning"><span class="closebtn">&times;</span>  <strong>Tidak Ada Data!</strong> Akun Anda Tidak Memiliki Data!</div>';
        }
    }

    //ambil data grafik
    $data = mysqli_query($koneksi, "SELECT tanggal, meter_pemakaian FROM meter_harian WHERE status = 0 AND id_alat = '$alat_id'");
    $getdata = mysqli_fetch_all($data, MYSQLI_ASSOC);

    $x = array(); // Untuk tanggal
    $y = array(); // Untuk pendapatan

    foreach ($getdata as $d) {
        $x[] = $d['tanggal'];
        $y[] = $d['meter_pemakaian'];
    }

    ?>
 <div class="row g-5 g-xl-12 mb-xl-12">
     <!--begin::Col-->
     <div class="col-lg-12 col-xl-12 col-xxl-12 mb-5 mb-xl-5">
         <!--begin::Chart widget 3-->
         <div class="card card-flush overflow-hidden h-md-100">

             <!--end::Header-->
             <!--begin::Card body-->
             <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
                 <!--begin::Statistics-->
                 <div class="px-9 mb-5">
                     <!--begin::Statistics-->
                     <div class="d-flex mb-2">
                         <span class="fs-2hx fw-bolder text-gray-800 me-2 lh-1 ls-n2">Grafik Pemakaian </span>
                     </div>
                 </div>
                 <!--end::Statistics-->
                 <!--begin::Chart-->
                 <canvas id="myChart" class="min-h-auto ps-4 pe-6" style="height: 300px"></canvas>
                 <!--end::Chart-->
             </div>
             <!--end::Card body-->
         </div>
         <!--end::Chart widget 3-->
     </div>
     <!--end::Col-->

 </div>

 <script>
     document.addEventListener("DOMContentLoaded", function() {
         const ctx = document.getElementById('myChart');

         new Chart(ctx, {
             type: 'line',
             data: {
                 labels: <?php echo json_encode($x) ?>,
                 datasets: [{
                     label: 'Meter Kubik',
                     data: <?php echo json_encode($y) ?>,
                     borderWidth: 1
                 }]
             },
             options: {
                 scales: {
                     y: {
                         beginAtZero: true
                     }
                 }
             }
         });
     });
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