<?php

namespace Midtrans;

require_once dirname(__FILE__) . '/midtrans/Midtrans.php';
Config::$serverKey = 'SB-Mid-server-UeqZJATbLSS92TsSrhP_1b4X';
Config::$clientKey = 'SB-Mid-client-1e6TCGbYSNfFfoLw';
printExampleWarningMessage();
//Config::$isProduction = true;
Config::$isSanitized = true;
Config::$is3ds = true;
//Ambil data
$order_id = $_GET['id_transaksi'];
$gross_amount = $_GET['total_bayar'];
$meter_pemakaian = $_GET['meter_pemakaian'];
// Required
$transaction_details = array(
  'order_id' => $order_id,
  'gross_amount' => $gross_amount, // no decimal allowed for creditcard
);
// Optional
$item1_details = array(
  'id' => '1',
  'price' => $gross_amount,
  'quantity' => 1,
  'name' => "Pembayaran Tagihan $meter_pemakaian M^3"
);
// Optional
$item_details = array($item1_details);
// Optional
$customer_details = array(
  'first_name'    => $order_id
);
// Fill transaction details
$transaction = array(
  'transaction_details' => $transaction_details,
  'customer_details' => $customer_details,
  'item_details' => $item_details,
);
$snap_token = '';
try {
  $snap_token = Snap::getSnapToken($transaction);
} catch (\Exception $e) {
  echo $e->getMessage();
}
echo "snapToken = " . $snap_token;

function printExampleWarningMessage()
{
  if (strpos(Config::$serverKey, 'your ') != false) {
    echo "<code>";
    echo "<h4>Please set your server key from sandbox</h4>";
    echo "In file: " . __FILE__;
    echo "<br>";
    echo "<br>";
    echo htmlspecialchars('Config::$serverKey = \'SB-Mid-server-UeqZJATbLSS92TsSrhP_1b4X\';');
    die();
  }
}

?>
<!doctype html>
<html lang="en" class="semi-dark">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

  <title></title>
</head>

<body>
  <div class="container">
    <div class="form-box box">
      <header>Pembayaran</header>
      <hr>
      <center>
        <p>Silahkan lanjutkan pembayaran anda dengan melakukan klik tombol <b>PAY</b> dibawah ini. Jika sudah melakukan pembayaran klik <b>KEMBALI KE MERCHANT</b> </br>Jika gagal, silahkan batalkan dan coba kembali.

        <div class="row mt-3">
          <div class="col">
            <button id="pay-button" class="btn btn-primary radius-15">Pay!</button>
          </div>
          <div class="col">
            <a href="payment_cancel.php?id_transaksi=<?php echo $_GET['id_transaksi'] ?>" class="btn btn-secondary radius-15 ">Batalkan</a>
          </div>
        </div>
      </center>
    </div>
  </div>

  <script src="https://app.sandbox.midtrans.com/snap/snap.js"></script>
  <script type="text/javascript">
    document.getElementById('pay-button').onclick = function() {
      // SnapToken acquired from previous step
      snap.pay('<?php echo $snap_token ?>', {
        // Optional
        onSuccess: function(result) {
          window.location = 'payment_succes.php?id_transaksi=<?= $order_id ?>';
        },
        // Optional
        onPending: function(result) {
          window.location = 'payment_pending.php?id_transaksi=<?= $order_id ?>';
        },
        // Optional
        onError: function(result) {
          window.location = 'payment_cancel.php?id_transaksi=<?= $order_id ?>';
        }
      });
    };
  </script>

</body>

</html>