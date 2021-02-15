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
        <div class="col-md-12">
            <?php if ($session->getFlashdata('success')) : ?>
                <div class="alert alert-success" role="alert">
                    Success! <?= $session->getFlashdata('success'); ?>
                </div>
            <?php endif;
            if ($session->getFlashdata('error')) : ?>
                <div class="alert alert-warning" role="alert">
                    Gagal! <?= $session->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>


            <div class="card">
                <h4 class="card-header bg-primary text-white">
                    Form Peserta <?= $data_instansi['nama']; ?>
                </h4>
                <div class="card-body">
                    <?php
                    $action = "/afiliasi/save_corporate";
                    $attributes = ['id' => 'form_corporate', 'name' => 'form_corporate'];
                    echo form_open_multipart($action, $attributes);

                    $form_hidden = [
                        'is_corporate' => "yes",
                        'id_instansi' => $id_instansi,
                        'id_marketing' => $id_marketing
                    ];

                    echo form_hidden($form_hidden);
                    echo csrf_field();
                    ?>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="excel" class="label-control">File Excel </label>

                                <input type="file" required name="excel" id="excel" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                <a href="/assets/format-excel/format-corporate.xlsx" target="_self" download="" class="text-link">
                                    <span class="text-danger">klik disini</span> Contoh Format Excel
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_test" class="col-label-control">Jenis Pemeriksaan</label>
                                <div class="btn-group-toggle" data-toggle="buttons">
                                    <?php
                                    foreach ($layanan_test_data as $key => $td) {
                                        $jt = $jenis_test->find($td['id_test']);
                                        $extras_radio =  [
                                            'id' => 'test' . $jt['id'],
                                            'onclick' => "return selectMenu('{$jt['id']}')",
                                            'autocomplete' => "off"
                                        ];
                                        $label_attribute = ['class' => "btn btn-outline-secondary mx-1", 'onclick' => "return selectMenu('{$jt['id']}')"];
                                        $radios = form_radio('id_test', $jt['id'], false, $extras_radio);
                                        echo form_label($radios . $jt['nama_test'], '', $label_attribute) . "\n";
                                        // echo form_button($attributes_button);
                                    }
                                    ?>
                                </div>
                                <!-- <div class="btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary active">
                                        <input type="radio" name="options" id="option1" autocomplete="off" checked> Active
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="options" id="option2" autocomplete="off"> Radio
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="options" id="option3" autocomplete="off"> Radio
                                    </label>
                                </div> -->
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
                                <button type="submit" class="btn btn-primary btn-block" onclick="btn_submit()" id="btn_submit">Submit Peserta</button>
                            </div>
                        </div>

                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    var jenis_test, nama_test, nama_layanan, biaya, array_peserta = [],
        array_table_peserta = [],
        jam_kunjungan;
    $("#loading").show();
    $(document).ready(function() {
        $("#loading_jam").hide();
        $("#loading").hide();
    });

    function selectMenu(id_jenis_test) {
        // $(".btn-test").removeClass("btn-primary active");
        // $("#test" + id_jenis_test).addClass("btn-primary active");
        return get_selected_test(id_jenis_test);
    }

    function btn_submit() {
        document.getElementById("btn_submit").disabled = true;
        $("#btn_submit").html("Loading...");
        document.getElementById("form_corporate").disabled = true;
    }

    function get_selected_test(id_jenis_test) {
        $.ajax({
            url: "<?= base_url('/select-test-corporate'); ?>",
            type: "GET",
            data: {
                id_test: id_jenis_test,
                type: '1',
                segmen: '2'
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
                html_radio += `<label class="label-control">
                                    <input type="radio" name="id_layanan" onchange="return getJadwal('${v.id}', '${v.nama_test}', '${v.nama_layanan}', '${v.biaya}')" value="${v.id}"> 
                                    ${v.nama_test} ${v.nama_layanan} <b class="text-primary">Rp ${formatNumber(v.biaya)}</b>
                                </label><br>`;
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
                var div_button_jam = '<div class="btn-group-toggle" data-toggle="buttons">';
                $.each(e, (i, v) => {
                    div_button_jam += `<label id="btnJam${v.value}" class="${v.btn_class} m-1" ${v.disabled}>
                    <input type="radio" name="jam_kunjungan" id="jam${v.value}" autocomplete="off" value="${v.value}">
                    ${v.label}</label>`;
                });
                div_button_jam += `</div>`;
                $("#loading_jam").hide();
                $("#data_jam").html(div_button_jam);
            }
        });
    }

    // function selectJam(jam) {
    //     $(".btn-jam").removeClass("btn-primary active");
    //     $(`#btnJam${jam}`).addClass("btn-primary active");
    //     jam_kunjungan = jam;
    // }

    // function detail_data_test(jenis_test) {
    //     $.get("<?= base_url('detail-data-test'); ?>?id=" + jenis_test, function(data) {
    //         harga_selected = data.biaya;
    //     });
    // }

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

    function formatNumber(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>
<?= $this->endSection(); ?>