<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row mt-3 mb-5">
        <div class="col-md-12">
            <div id="loading" class="row">
                <div class="spinner-grow text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-secondary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-success" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-danger" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-info" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-light" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <h4 class="card-header bg-primary text-white">
                    Form Peserta Home Service
                </h4>
                <div class="card-body">
                    <form action="" id="form_add_peserta">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama" class="col-label-control">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" autocomplete="none" aria-autocomplete="none">
                                </div>
                                <div class="form-group">
                                    <label for="nik" class="col-label-control">Nomor KTP/NIK</label>
                                    <input type="number" name="nik" id="nik" class="form-control" autocomplete="none" aria-autocomplete="none" maxlength="16" minlength="15">
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="col-label-control">Nomor WhatsApp</label>
                                    <input type="number" inputmode="tel" name="phone" id="phone" class="form-control" autocomplete="none" aria-autocomplete="none" maxlength="13">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-label-control">Email</label>
                                    <input type="email" inputmode="email" name="email" id="email" class="form-control" autocomplete="none" aria-autocomplete="none">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-label-control">Jenis Kelamin</label>
                                    <div>
                                        <label for="jk1"><input type="radio" name="jenis_kelamin" id="jk1" value="pria"> Pria</label>
                                        <label for="jk2"><input type="radio" name="jenis_kelamin" id="jk2" value="wanita"> Wanita</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tempat_lahir" class="col-label-control">Tempat Lahir</label>
                                    <input type="text" inputmode="text" name="tempat_lahir" id="tempat_lahir" class="form-control" autocomplete="none" aria-autocomplete="none">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir" class="col-label-control">Tanggal Lahir</label>
                                    <input type="date" inputmode="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" autocomplete="none" aria-autocomplete="none">
                                </div>
                                <div class="form-group">
                                    <label for="alamat" class="col-label-control">Alamat Lengkap</label>
                                    <textarea name="alamat" id="alamat" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_test" class="col-label-control">Jenis Pemeriksaan</label>
                                    <div>
                                        <?php
                                        foreach ($layanan_test_data as $key => $td) {
                                            $jt = $jenis_test->find($td['id_test']);
                                        ?>
                                            <button class="btn btn-default btn-sm my-2 btn-test" id="test<?= $jt['id'] ?>" type="button" role="button" onclick="return selectMenu('<?= $jt['id']; ?>')"><?= $jt['nama_test']; ?></button>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tipe" class="col-label-control">Tipe</label>
                                    <div id="data_tipe">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tgl_kunjungan" class="col-label-control">Tanggal Kunjungan</label>
                                    <input type="date" name="tgl_kunjungan" id="tgl_kunjungan" class="form-control" autocomplete="off" aria-autocomplete="none" min="<?= date('Y-m-d'); ?>" value="<?= date('Y-m-d'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="jam_kunjuangan" class="col-label-control">Jam Kunjungan</label>
                                    <div id="loading_jam">
                                        Loading..
                                    </div>
                                    <div id="data_jam">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-block" onclick="return add_peserta()">Tambah Peserta</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header bg-primary text-white">
                    Tabel Peserta
                </h5>
                <div class="card-body" style="padding: 1rem 0;">
                    <table class="table table-bordered table-condensed table-hover" id="table_peserta">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Pemeriksaan</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="data_peserta"></tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="float-right" id="collective">
                        <button class="btn btn-primary" type="button" onclick="submit_peserta_hs()">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $midtrans_client_key; ?>"></script> -->
<script>
    var jenis_test, nama_test, nama_layanan, biaya, array_peserta = [],
        array_table_peserta = [],
        jam_kunjungan;
    $("#loading").show();
    $(document).ready(function() {
        $("#loading_jam").hide();
        $("#loading").hide();
        $("#collective").hide();
        // document.getElementById("add_peserta").addEventListener("click")
    });

    // function getMenu() {
    //     $.get('<?= base_url('menu'); ?>').then(e => {
    //         var menus = '';
    //         $.each(e, (i, v) => {
    //             menus += `<button class="btn btn-default btn-sm" type="button" role="button" onclick="return selectMenu(${v.id_jenis_test})">${v.keterangan}</button>`;
    //         });
    //         $("#menus").html(menus);
    //         $("#loading").hide();
    //     });
    // }

    function selectMenu(id_jenis_test) {
        $(".btn-test").removeClass("btn-primary active");
        $("#test" + id_jenis_test).addClass("btn-primary active");
        get_selected_test(id_jenis_test);
    }

    function get_selected_test(id_jenis_test) {
        $.ajax({
            url: "<?= base_url('select-test'); ?>",
            type: "GET",
            data: {
                id_test: id_jenis_test,
                type: '2',
                segmen: '1'
            },
            success: on_success_get_selected_test,
            error: function(xhr, ajaxOptions, thrownError) {
                console.error(ajaxOptions);
                console.error(xhr.status);
                console.error("Error iki ");
                console.error(thrownError);
            }
        });
    }

    function on_success_get_selected_test(data, status, xhr) {
        let result_data = data.data;
        console.table(result_data);
        if (data.data.length > 0) {

            let html_radio = "";
            $.each(result_data, (k, v) => {
                html_radio += `<label><input type="radio" name="id_layanan_test" onchange="return getJadwal('${v.id}', '${v.nama_test}', '${v.nama_layanan}', '${v.biaya}')" value="${v.id}"> ${v.nama_test} ${v.nama_layanan} <b class="text-primary">${v.biaya}</b></label>`;
            });
            $("#data_tipe").html(html_radio)
        }
        // $("[name=id_layanan_test]").change(getJadwal);
    }

    function getJadwal(id_test, test, layanan, harga) {
        $("#loading_jam").show();
        $("#data_jam").empty();
        jenis_test = id_test,
            nama_test = test, nama_layanan = layanan, biaya = harga;
        if (jenis_test == "" || jenis_test == null || jenis_test == undefined) {
            showError('Jenis Pemeriksaan wajib dipilih dulu');
            return false;
        }
        let tgl_kunjungan = $("#tgl_kunjungan").val();
        let data = {
            jenis_test,
            tgl_kunjungan
        };
        jadwal(data);
    }

    function jadwal(data) {
        $.get("<?= base_url('cek_jadwal'); ?>", data).then(e => {
            if (e.length > 0) {
                var div_button_jam = '';
                $.each(e, (i, v) => {
                    div_button_jam += `<button type="button" role="button" id="btnJam${v.value}" class="${v.btn_class} btn-jam" ${v.disabled} onclick="selectJam(${v.value})" data-id="${v.value}">${v.label}</button>`;
                });
                $("#loading_jam").hide();
                $("#data_jam").html(div_button_jam);
            }
        });
    }

    function selectJam(jam) {
        $(".btn-jam").removeClass("btn-primary active");
        $(`#btnJam${jam}`).addClass("btn-primary active");
        jam_kunjungan = jam;
    }

    function detail_data_test(jenis_test) {
        $.get("<?= base_url('detail-data-test'); ?>?id=" + jenis_test, function(data) {
            harga_selected = data.biaya;
        });
    }

    function add_peserta() {
        let nama = $("#nama").val();
        let nik = $("#nik").val();
        let phone = $("#phone").val();
        let email = $("#email").val();
        let jenis_kelamin = $("[name=jenis_kelamin]:checked").val();
        let tempat_lahir = $("#tempat_lahir").val();
        let tanggal_lahir = $("#tanggal_lahir").val();
        let alamat = $("#alamat").val();
        let tgl_kunjungan = $("#tgl_kunjungan").val();
        let temp_peserta = {
            nama,
            nik,
            phone,
            email,
            jenis_kelamin,
            tempat_lahir,
            tanggal_lahir,
            alamat,
            jam_kunjungan,
            tgl_kunjungan,
            biaya,
            jenis_test
        };
        array_peserta.push(temp_peserta);
        let temp_table = {
            jenis_test,
            nama,
            nik,
            nama_test,
            nama_layanan,
            biaya
        };
        array_table_peserta.push(temp_table);
        show_peserta_table();
        reset_inputs();
    }

    function reset_inputs() {
        $("#data_tipe").empty();
        $("#data_jam").empty();
        $(".btn-test").removeClass("btn-primary active");
        document.getElementById("form_add_peserta").reset();
    }

    function show_peserta_table() {
        let html_table = "";
        $.each(array_table_peserta, (k, v) => {
            html_table += `<tr id="peserta${k}">
            <td>${v.nama}</td>
            <td>${v.nik}</td>
            <td>${v.nama_layanan} ${v.nama_test}</td>
            <td>${v.biaya}</td>
            <td><button class="btn btn-sm btn-danger btn-icon" type="button" role="button" onclick="return remove_peserta(${k})">Hapus</button></td>
            </tr>`;
        });
        $("#data_peserta").html(html_table);
        if (array_peserta.length >= 5) {
            $("#collective").show();
        } else {
            $("#collective").hide();
        }
    }

    function remove_peserta(key) {
        array_table_peserta.splice(key, 1);
        array_peserta.splice(key, 1);
        $("#peserta" + key).hide();

    }

    function cancelData(result) {
        console.log('result', result);
    }

    function showPayment(midtransToken) {
        snap.pay(midtransToken, {
            onSuccess: result => {
                updateData(result);
            },
            onPending: result => {
                updateData(result);
            },
            onError: result => {
                cancelData(result);
            },
            onClose: () => {
                cancelData(result);
            }
        });
    }

    function showError(text) {
        // toggleForm();
        Swal.fire({
            title: 'Oopps!',
            text: text,
            type: "info",
            icon: "error",
            confirmButtonText: 'Ok',
            confirmButtonColor: "#D33",
        });
    }

    function showToast(type = 'info', text) {
        return Swal.fire(
            text,
            '',
            type
        );
    }

    // fun

    function showImg(urlImg = "", title = 'Notification', footer = '') {
        return Swal.fire({
            title: title,
            imageUrl: urlImg,
            imageHeight: 400,
            imageWeight: 400,
            imageAlt: 'QRCODE',
            footer: footer
            // type: 'success',
            // text: "Berhasil M"
        });
    }

    function submit_peserta_hs() {
        let url_hs = '<?= base_url('api/save-hs'); ?>';
        let data = {
            token: '<?= csrf_hash(); ?>',
            peserta: array_peserta
        };
        $.ajax({
            url: url_hs,
            type: 'post',
            data: data,
            success: function(data, status, xhr) {
                showToast('success', 'Berhasil simpan data peserta untuk home service, silahkan cek pada email untuk qr code yang nantinya dibutuhkan saat kehadiran');
                setInterval(window.location.reload, 5000);
            },
            error: function(err) {
                showError("terjadi kesalahan dalam menyimpan data anda, silahkan menunggu beberapa saat. Terima kasih");
            }
        })
    }

    function formatNumber(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>
<?= $this->endSection(); ?>