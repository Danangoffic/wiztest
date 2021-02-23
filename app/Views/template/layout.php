<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>QUICKTEST.ID - <?= $title; ?> - Registrasi Test PCR, Antigen dan Rapid Test</title>

    <meta property="og:url" content="<?= base_url(); ?>" />
    <meta property="og:site_name" content="QuickTest By Danang">
    <meta property="og:image" itemprop="image primaryImageOfPage" content="assets/images/logo-warna.png" />
    <meta property="og:image:width" content="300">
    <meta property="og:image:height" content="300">
    <meta property="og:type" content="website" />
    <meta property="og:image:type" content="image/jpeg">
    <meta name="description" content="Registrasi Test Covid-19 menggunakan SWAB PCR, RAPID TEST & SWAB ANTIGEN">
    <meta name="keywords" content="test covid, test pcr, swab pcr, rapid antigen">
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:domain" content="https://reg.quicktest.id" />
    <meta name="twitter:title" property="og:title" itemprop="name" content="QUICKTEST.ID - <?= $title; ?> - Registrasi Test PCR, Antigen dan Rapid Test" />
    <meta name="twitter:description" property="og:description" itemprop="description" content="Registrasi Test Covid-19 menggunakan SWAB PCR, RAPID TEST & SWAB ANTIGEN" />

    <!-- Bootstrap CSS -->
    <link rel="canoncial" href="<?= base_url(); ?>">
    <link rel="shortcut icon" href="assets/images/logo-warna.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="assets/images/logo-warna.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="<?= base_url('assets/ClassyQr/js/jquery.classyqr.min.js'); ?>"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        .img-index {
            background-image: url('/assets/images/registrasi web.jpg');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            min-height: 560px !important;
        }

        .bg-primary-quicktest {
            background-color: #1a428a;
            color: white;
        }

        .text-primary {
            color: #1a428a !important;
            /* font-family: Bergen, "Bergen SemiBold"; */
        }

        .card {
            box-shadow: 2px 2px 10px 5px #ccc;
        }

        .jumbotron {
            margin-bottom: 0;
        }

        .radius-30 {
            border-radius: 30px;
        }

        .footer {
            height: 56px;
        }
    </style>


    <!-- <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script> -->


</head>

<body>

    <div style="background-color: #eee;">
        <?= $this->include('template/navbar'); ?>
    </div>


    <?= $this->renderSection('content'); ?>
    <div class="container-fluid bg-primary-quicktest">
        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron p-0 bg-primary-quicktest">
                    <p class="my-4 text-center"><?= date('Y'); ?>&copy; PT.QUICKTEST LABORATORIUM INDONESIA</p>
                </div>
                <!-- <footer class="position-relative fixed-bottom text-center footer">
                    
                </footer> -->
            </div>
        </div>
    </div>
</body>

</html>