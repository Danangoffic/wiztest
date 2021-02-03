<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.min.css">

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="/assets/ClassyQr/js/jquery.classyqr.js"></script>
    <script>
        let noreg = "<?= $detail_customer['customer_unique']; ?>";
        $('#qrcode').ClassyQR({
            create: true,
            type: 'url',
            text: "<?= base_url("api/hadir/"); ?>" + noreg
        });
    </script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script> -->

    <title>QUICKTEST.ID - <?= $title; ?></title>
</head>

<body>

    <div class="card card-primary card-outline">
        <!-- /.card-header -->
        <div class="card-body p-0">
            <!-- /.mailbox-controls -->
            <div class="mailbox-read-message">
                <h3>Quick Test Covid</h3>
                <p>Hello <?= $detail_customer['nama']; ?>,</p>

                <?php
                $responseMessage = "";
                $transType = $notif->transaction_status;
                if ($transType == "settlement" || $transType == "capture") {
                    $responseMessage = "<p>Terima kasih telah melakukan pembayaran pada kami, berikut kami berikan gambar QR Code untuk anda 
                    hadir pada tempat kami saat melakukan konfirmasi kedatangan pada tanggal " . $detail_customer['tgl_kunjungan'] .
                        " pukul " . $detail_customer['jam_kedatangan'] . ".</p>";
                    echo $responseMessage;
                }
                ?>
                <div id="qrcode"></div>
                <p>Thanks,<br>QuickTest Info</p>
            </div>
            <!-- /.mailbox-read-message -->
        </div>
    </div>
</body>

</html>