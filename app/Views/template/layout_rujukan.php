<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta property="og:url" content="https://quicktest.id" />
    <meta property="og:site_name" content="QuickTest By Danang">
    <meta property="og:image" itemprop="image primaryImageOfPage" content="###" />
    <meta property="og:image:width" content="300">
    <meta property="og:image:height" content="300">
    <meta property="og:type" content="website" />
    <meta property="og:image:type" content="image/jpeg">
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:domain" content="quicktest.id" />
    <meta name="twitter:title" property="og:title" itemprop="name" content="Registrasi Test Covid-19 oleh Klinik Utama QuickTest ID" />
    <meta name="twitter:description" property="og:description" itemprop="description" content="Macam-macam test yang bisa dipilih adalah SWAB PCR, RAPID TEST & SWAB ANTIGEN" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.min.css">

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="<?= base_url('assets/ClassyQr/js/jquery.classyqr.min.js'); ?>"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <!-- <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script> -->

    <title>REGISTRASI TEST ID <?= $title; ?></title>
</head>

<body>

    <?= $this->include('template/navbar_rujukan'); ?>

    <?= $this->renderSection('content'); ?>

</body>

</html>