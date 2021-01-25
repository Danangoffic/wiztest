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


        @media print {
            @page {
                margin: 3cm;
                /* max-height: 15cm;
                max-width: 20cm; */
                size: 80mm 80mm;
            }

            html,
            body {
                background-color: black;
                visibility: hidden;
            }

            #barcodeTarget {
                visibility: visible;
                background-color: white;
                /* margin: auto; */
                margin-top: 4cm;
                position: absolute;
                left: 0;
                right: 0;
                top: 0;
                bottom: 0;
                display: block;
            }
        }
    </style>
</head>

<body>
    <center>
        <div id="barcodeTarget">
            <center>
                <strong></strong>
                <!-- <img src="<?= $html_img; ?>" alt=""> -->
                <?= $html_img; ?>
            </center>
        </div>
    </center>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <!-- <script src="<?= base_url('assets/jquery-barcode.min.js'); ?>"></script> -->
    <script>
        // $(window).load(function() {
        //     let html_img = document.getElementById('barcodeTarget').innerHTML;
        //     let a = window;
        //     a.print();
        // });
    </script>
</body>

</html>