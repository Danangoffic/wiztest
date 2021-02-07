<html lang="en" style="height: auto;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quicktest.id | <?= $title; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
</head>

<body class="container-fluid">
    <div class="card">
        <!-- Navbar -->

        <!-- /.navbar -->

        <!-- Main Sidebar Container -->


        <!-- Content Wrapper. Contains page content -->
        <div class="card-header">
            <div class="row">
                <div class="col-md-3">
                    <h1>Antrian <?= $jenis_test; ?></h1>
                </div>
                <div class="col-md-3">
                    <h1><span class="float-right badge badge-info">Bilik <?= $nomor_bilik; ?></span></h1>
                </div>
                <div class="col-md-3">&nbsp;</div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-6">
                    <!-- small card -->
                    <div class="small-box bg-info">
                        <div class="inner text-center">
                            <h1 id="no_antrian_on_call">0</h1>

                            <h2>On Call</h2>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart bounce"></i>
                        </div>
                        <!-- <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a> -->
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-6 col-6">
                    <!-- small card -->
                    <div class="small-box bg-success">
                        <div class="inner text-center">
                            <h1 id="no_antrian">0</h1>

                            <h2>Antrian Selanjutnya</h2>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <!-- <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a> -->
                    </div>
                </div>
                <!-- ./col -->

                <!-- ./col -->
            </div>
        </div>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/assets/dist/js/demo.js"></script>

    <script>
        var bilik = "<?= $nomor_bilik; ?>";
        var url_antrian = "<?= $url_antrian; ?>";
        var url_on_call = "<?= $url_on_call ?>";
        $(document).ready(function() {
            console.log("Ready");
            get_antrian();
            get_on_call();
            setInterval(get_antrian, 2000);
            setInterval(get_on_call, 2000);
        });

        function get_antrian() {
            $.ajax({
                url: url_antrian,
                data: {
                    nomor_bilik: bilik
                },
                type: "GET",
                success: function(data, status) {
                    let result = data.data;
                    if (result != null) {
                        let no_antrian = result.no_antrian;
                        let nama = result.nama;
                        let bilik_antrian = result.nomor_bilik;
                        $("#no_antrian").html(no_antrian);
                    }

                    console.log("Get Antrian : " + status);
                },
                error: function(err) {
                    console.error("Get Antrian : " + err);
                }
            })
        }

        function get_on_call() {
            $.ajax({
                url: url_on_call,
                data: {
                    nomor_bilik: bilik
                },
                type: "GET",
                success: function(data, status) {
                    console.log("Get On Call : " + status);
                    let result = data.data;
                    if (result != null || result != []) {
                        let no_antrian = result.no_antrian;
                        let nama = result.nama;
                        let bilik_antrian = result.nomor_bilik;
                        $("#no_antrian_on_call").html(no_antrian);
                    }
                },
                errro: function(err) {
                    console.error("Get On Call : " + err);
                }
            })
        }
    </script>

</body>

</html>