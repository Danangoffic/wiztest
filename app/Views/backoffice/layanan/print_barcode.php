<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @page {
            /* margin: 0px; */
        }

        body,
        p {
            margin: 0px;
        }
    </style>
</head>

<body>
    <center>
        <?= $url; ?>
        <p><?= $detailCustomer['nama']; ?></p>
        <p><?= $detailCustomer['jenis_kelamin']; ?>/<?= $detailCustomer['tanggal_lahir']; ?></p>
        <p><?= $detailCustomer['customer_unique']; ?></p>
        <div id="barcodeTarget"></div>
    </center>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="<?= base_url('assets/jquery-barcode.min.js'); ?>"></script>
    <script>
        $(window).load(function() {
            var btype = "code128",
                value = "<?= $detailCustomer['customer_unique']; ?>;<?= $detailCustomer['nama']; ?>";
            var settings = {
                output: "css",
                bgColor: "#FFFFFF",
                color: "#000000",
                barWidth: 1,
                barHeight: 25,
                moduleSize: 25,
                posX: 0,
                posY: 0,
                addQuietZone: true,
                showHRI: false
            };
            $("#barcodeTarget").html("").show().barcode(value, btype, settings);
        });
    </script>
</body>

</html>