<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>
<div class="container" style="margin-bottom: 1.75em;">
    <div class="row mt-5">
        <!-- <div class="col-lg-3">&nbsp;</div> -->
        <div class="col-lg-12">
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
            <div class="row" id="menus">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h2 style="vertical-align: middle;" class="text-center my-5">Jam Operasional</h2>
                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <td class="align-middle">
                                        <h5>Week days</h5>
                                    </td>
                                    <td class="align-middle">
                                        <h5>(07.00-22.00)</h5><br>
                                        <small>Tidak termasuk libur nasional</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">
                                        <h5>Week end</h5>
                                    </td>
                                    <td class="align-middle">
                                        <h5>(07.00 - 22.00)</h5>
                                    </td>
                                </tr>
                            </table>
                            <!-- <h5>Week days</h5><br>
                            <h5>Week end</h5>
                        </div>
                        <div class="col-md-3">
                            <h5>(07.00 - 22.00)</h5>
                            <small>Tidak termasuk libur nasional</small><br>
                            <h5>(07.00 - 22.00)</h5>
                        </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Reschedule -->
    <div class="modal fade" id="modal_reschedule" tabindex="-1" aria-labelledby="modal-rescheduleLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-rescheduleLabel">Reschedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" name="noRegistration" class="form-control" id="noRegistration" aria-describedby="noRegistration" placeholder="Masukkan Nomor Registrasi">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" onclick="return getRescheduleNoRegistration()">Cari</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_cari_hasil" tabindex="-1" aria-labelledby="modal-rescheduleLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-cari-hasilLabel">Reschedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" name="noRegistrationHasil" class="form-control" id="noRegistrationHasil" aria-describedby="noRegistrationHasil" placeholder="Masukkan Nomor Registrasi">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" onclick="return getHasilNoRegistation()">Cari</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Reschedule -->
    <div class="modal fade" id="modal_check_registration" tabindex="-1" aria-labelledby="modal_check_registrationLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_check_registrationLabel">Check No Registration</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" name="noRegistration2" class="form-control" id="noRegistration2" aria-describedby="noRegistration2" placeholder="Masukkan Nomor Registrasi">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" onclick="return getCheckNoRegistration()">Cari</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div id="loading_check_no_registration hidden" class="row">
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
                        <div id="data_result_check_registration"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pcr -->
    <div class="modal fade" id="modal_registrasi" tabindex="-1" aria-labelledby="modal_registrasi" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal_pcr">Form Registrasi <strong id="title_jenis_test"></strong></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="" id="page1">
                    <div class="modal-body">
                        <input type="hidden" name="jenis_test">
                        <div class="form-group row">
                            <label for="nama" class="col-md-3">Nama Lengkap</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nik" class="col-md-3">Nomor KTP/NIK</label>
                            <div class="col-md-9">
                                <input type="text" name="nik" id="nik" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-md-3">Nomor WhatsApp</label>
                            <div class="col-md-9"><input type="text" name="phone" id="phone" class="form-control"></div>
                        </div>
                        <div class="form-group row">
                            <label for="confirmphone" class="col-md-3">Konfirmasi Nomor WhatsApp</label>
                            <div class="col-md-9"><input type="text" name="confirmphone" id="confirmphone" class="form-control"></div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-3">Email</label>
                            <div class="col-md-9"><input type="email" name="email" id="email" class="form-control"></div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-md-3">Jenis Kelamin</label>
                            <div class="col-md-9">
                                <label class="form-check-label ml-4" for="jenis_kelamin">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin" value="Pria">
                                    Pria
                                </label>
                                <label class="form-check-label ml-4" for="jenis_kelamin2">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin2" value="Wanita">
                                    Wanita
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tempat_lahir" class="col-md-3">Tempat Lahir</label>
                            <div class="col-md-9"><input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"></div>
                        </div>
                        <div class="form-group row">
                            <label for="tgl_lahir" class="col-md-3">Tanggal Lahir</label>
                            <div class="col-md-9"><input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control"></div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-md-3">Alamat Lengkap</label>
                            <div class="col-md-9">
                                <textarea name="alamat" id="alamat" cols="" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="marketing" class="col-md-3">Marketing</label>
                            <div class="col-md-9">
                                <select name="marketing" id="marketing" class="form-control">
                                    <?php
                                    foreach ($marketings as $key => $value) {
                                    ?>
                                        <option value="<?= $value['id']; ?>" <?= ($value['id'] == '1') ? 'selected' : ''; ?>><?= $value['nama_marketing']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="nextForm()">Lanjut</button>
                    </div>
                </div>


                <div class="" id="page2">
                    <div class="modal-body">
                        <strong>Jenis Pemeriksaan</strong>
                        <div class="" id="data_jenis_pemeriksaan">

                        </div>
                        <div class="form-group">
                            <label for="tgl_kunjungan">Tanggal Kunjungan</label>
                            <div class="col-4">
                                <input type="date" name="tgl_kunjungan" id="tgl_kunjungan" class="form-control" min="<?= date('Y-m-d'); ?>" value="<?= date('Y-m-d'); ?>" onchange="getJadwal()">
                            </div>
                        </div>
                        <div class="form-group" id="data_pilih_jam">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="backForm" onclick="backForm()">Kembali</button>
                        <button type="button" class="btn btn-primary" id="registrasi">Registrasi</button>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script type="text/javascript" src="<?= $snap_url_js; ?>" data-client-key="<?= $midtrans_client_key; ?>"></script>
    <script>
        var id_jenis_test, nama_jenis_test, jam_kunjungan, token_client;
        var midtransToken, invoice_number, transaction;
        $("#loading").show();
        $(document).ready(() => {

            getMenu();
            $(".modal").on("hide.bs.modal", function(e) {
                console.log(e);
                window.location.reload();
            });
            document.getElementById('registrasi').addEventListener('click', registrasi, false);
            // document.getElementById('nextPageForm').addEventListener('click', toggleForm, false);
            // document.getElementById('backPageForm').addEventListener('click', toggleForm, false);
            $("#tgl_kunjungan").change(() => {
                let jns_kjg = $("[name=jenis_kunjungan]:checked").val();
                if (jns_kjg == "" || jns_kjg == null || jns_kjg == undefined) {
                    return false;
                } else {
                    getJadwal();
                }
            });

        });

        function getMenu() {
            $.get('<?= base_url('menu'); ?>').then(e => {
                var menus = '';
                let title_menu = `
            <div class="col-lg-12">
            <h4 class="text-center">OUR SERVICES</h4>
            </div>
            `;
                menus += title_menu;
                $.each(e, (i, v) => {
                    menus += `<div class="col-lg-4 my-5">
                    <div class="card" onclick="modalRegistrasi(${v.id_jenis_test})">
                        <div class="card-body">
                            <img src="<?= base_url('assets'); ?>/${v.img_url}" class="card-img-top" alt="${v.keterangan}">
                            <h5 class="card-title text-center" style="margin-top: 1.25em">${v.keterangan}</h5>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-outline-danger btn-block"><strong>CHECK OUT</strong></a>
                        </div>
                    </div>
                </div>`;
                });
                $("#menus").html(menus);
                $("#loading").hide();
            });
        }

        function nextForm() {
            if (cek_data_pribadi()) {
                getDetailForm2(id_jenis_test);
                $("#page1, #page2").toggle();
            }
        }

        function backForm() {
            $("#data_jenis_pemeriksaan").empty();
            $("#tgl_kunjungan").val('');
            $("#page1, #page2").toggle();
            $("#data_pilih_jam").empty();
        }

        function getDetailForm2(id_jenis_test) {
            $.get('<?= base_url('detail_form2'); ?>', {
                id_jenis_test: id_jenis_test,
                id_pemeriksaan: 1,
                segmen: 1
            }).then(e => {
                var jp = '';
                $.each(e.data_layanan, (i, v) => {
                    console.log(v);
                    jp += `<div class="form-group"><label class="form-check-label ml-4" for="jenis_test${i}">
                                <input class="form-check-input" type="radio" name="jenis_test" id="jenis_test${i}" value="${v.id}" onclick="getJadwal()">
                                ${nama_jenis_test + ' ' + v.nama_layanan} <strong class="text-primary">Rp ${formatNumber(v.biaya)}</strong>
                            </label></div>`
                });
                $("#data_jenis_pemeriksaan").html(jp);
            });
            $("[name=jenis_pemeriksaan]").change(getJadwal);
        }

        function getJadwal() {
            let jenis_test = $("[name=jenis_test]:checked").val();
            if (jenis_test == "" || jenis_test == null || jenis_test == undefined) {
                showError('Jenis Pemeriksaan wajib dipilih dulu');
                return false;
            }
            let tgl_kunjungan = $("#tgl_kunjungan").val();
            let data = {
                jenis_test,
                tgl_kunjungan
            };
            $.get("<?= base_url('cek_jadwal'); ?>", data).then(e => {
                if (e.length > 0) {
                    var div_button_jam = '';
                    $.each(e, (i, v) => {
                        div_button_jam += `<button id="btnJam${v.value}" class="btn ${v.btn_class} btn-jam" ${v.disabled} onclick="selectJam(${v.value})" data-id="${v.value}">${v.label}</button>`;
                    });
                    $("#data_pilih_jam").html(div_button_jam);
                }
            });
        }

        function selectJam(jam) {
            $(".btn-jam").removeClass("active");
            $(`#btnJam${jam}`).addClass("active");
            jam_kunjungan = jam;
        }

        function toggleForm() {
            if (id_jenis_test == 1) {
                if (cek_data_pribadi()) {
                    $("#page1, #page2").toggle();
                }
            }

        }

        function modalRegistrasi(jenis_test) {
            id_jenis_test = jenis_test;
            $("#modal_registrasi").modal('toggle');
            $("#page1").show();
            $("#page2").hide();
            $("#jenis_test").val(jenis_test);
            if (jenis_test == 1) {
                nama_jenis_test = "Swab";
                $("#title_jenis_test").text('SWAB PCR');
            } else if (jenis_test == 2) {
                nama_jenis_test = "Rapid Test";
                $("#title_jenis_test").text('RAPID TEST');
            } else if (jenis_test == 3) {
                nama_jenis_test = "Swab Antigen";
                $("#title_jenis_test").text('SWAB ANTIGEN');
            }

        }

        function cek_data_pribadi() {
            let akses_next_page = true;
            let nama = $("#nama").val();
            let nik = $("#nik").val().toString();
            let phone = $("#phone").val();
            let confirmPhone = $("[name=confirmphone]").val();
            let email = $("#email").val();
            let jenis_kelamin = $("[name=jenis_kelamin]:checked").val();
            let tempat_lahir = $("#tempat_lahir").val();
            let tgl_lahir = $("#tgl_lahir").val();
            let alamat = $("#alamat").val();
            let marketing = $("#marketing").val();
            let jenis_layanan_test = $("#jenis_layanan_test").val();
            let instansi = 1;
            let faskes_asal = 1;
            let jenis_pemeriksaan = 1;
            let jenis_test = $("[name=jenis_test]:checked").val();

            if (nama == "" || nama == null || nama.length == 0) {
                showError('Nama Lengkap Wajib Diisi');
                return false;
            }
            if (nik == "" || nik == null || nik.length == 0 || nik == 0) {
                showError('NIK Wajib Diisi');
                return false;
            } else if (nik.length < 16) {
                showError('NIK Wajib Diisi dengan 16 angka');
                return false;
            }
            if (phone == "" || phone == null || phone.length == 0) {
                showError('Nomor WhatsApp Wajib diisi');
                return false;
            }

            if (phone != confirmPhone) {
                showError('Nomor WhatsApp harus sesuai dengan Nomor Konfirmasi WhatsApp');
                return false;
            }

            if (email == "" || email == null) {
                showError('Email wajib diisi');
                return false;
            }

            if (jenis_kelamin == "" || jenis_kelamin == undefined || jenis_kelamin == null) {
                showError('Jenis kelamin wajib diisi');
                return false;
            }
            if (tempat_lahir == "" || tempat_lahir == undefined || tempat_lahir == null) {
                showError('Tempat lahir wajib diisi');
                return false;
            }
            if (tgl_lahir == "" || tgl_lahir == null || tgl_lahir == undefined) {
                showError('Tanggal lahir wajib diisi');
                return false;
            }
            if (alamat == "" || alamat == null || alamat == undefined) {
                showError('Alamat lengkap wajib diisi');
                return false;
            }
            if (marketing == "" || marketing == null || marketing == undefined) {
                showError('Marketing wajib dipilih');
                return false;
            }
            return akses_next_page;
        }

        function registrasi() {
            let nama = $("#nama").val();
            let nik = $("#nik").val();
            let phone = $("#phone").val().toString();
            let confirmPhone = $("#confirmphone").val().toString();
            let email = $("#email").val();
            let jenis_kelamin = $("#jenis_kelamin").val();
            let tempat_lahir = $("#tempat_lahir").val();
            let tgl_lahir = $("#tgl_lahir").val();
            let alamat = $("#alamat").val();
            let marketing = $("#marketing").val();
            let jenis_layanan_test = $("#jenis_layanan_test").val();
            let tgl_kunjungan = $("#tgl_kunjungan").val();
            // let jam_kunjungan = $("[name=jam_kunjungan]:checked").val();
            let jenis_test = $("[name=jenis_test]:checked").val();
            let instansi = 1;
            let faskes_asal = 1;
            let jenis_pemeriksaan = $("[name=jenis_pemeriksaan]:checked").val();
            let jenis_layanan = 1;
            if (jam_kunjungan == "" || jam_kunjungan == null || jam_kunjungan == undefined) {
                showError('Jam kunjungan harus dipilih terlebih dahulu');
                console.error('Jam kunjungan belum dipilih');
                return false;
            }
            if (jenis_test == "" || jenis_test == null) {
                showError('Jenis Pemeriksaan harus dipilih');
                return false;
            }
            let dataSend = {
                nama,
                nik,
                phone,
                email,
                jenis_kelamin,
                tempat_lahir,
                tgl_lahir,
                alamat,
                marketing,
                jenis_layanan_test,
                jenis_test,
                jam_kunjungan,
                instansi,
                faskes_asal,
                jenis_pemeriksaan,
                jenis_layanan,
                tgl_kunjungan,
                jenis_pemeriksaan: 1
            };
            console.log("Data Send: ", dataSend);
            let url_post_registration = '<?= base_url('api/registration') ?>';
            // $.ajax({
            //     url: url_post_registration,
            //     type: 'POST',
            //     data: dataSend,
            //     dataType: 'application/json',
            //     success: (data, status) => {
            //         console.log('STATUS', status);
            //         let midtrans_return = data.data;
            //         let invoice_number = data.invoice_number;
            //         let transaction = data.transaction;
            //         console.log('midtrans return : ', midtrans_return);
            //         console.log('invoice number : ', invoice_number);
            //         console.log('transaction detail : ', transaction);
            //     },
            //     // error: e => console.error(e)
            // });

            $.post(url_post_registration, dataSend).then((data, status) => {
                if (status == "success") {
                    console.log('STATUS', status);
                    let midtrans_return = data.midtrans.data;
                    midtransToken = midtrans_return.token;
                    invoice_number = data.invoice_number;
                    transaction = data.transaction;
                    console.log('midtrans return : ', midtrans_return);
                    console.log('invoice number : ', invoice_number);
                    console.log('transaction detail : ', transaction);
                    $("#registrasi, #backForm").addClass("disabled");
                    $("#registrasi").html(`Loading..<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`);
                    showPayment(midtransToken);
                }
                // snap.show();
            });
        }

        function updateData(result) {
            $("#registrasi").removeClass('btn-primary').addClass('btn-success');
            $("#registrasi").html(`Success <i class="fa check-circle"></i>`);
            console.log('result', result);
            var payent_type = result.payment_type;
            var order_id = result.order_id;
            var pdf_url = result.pdf_url;
            var gross_amount = result.gross_amount;
            var transaction_status = result.transaction_status;
            var status_code = result.status_code;
            var finish_url = result.finish_redirect_url;
            var transaction_id = result.transaction_id;
            var data_object = {
                payent_type,
                order_id,
                pdf_url,
                gross_amount,
                transaction_status,
                status_code,
                finish_url,
                transaction_id
            };
            let url_update = '<?= base_url('api/update_status'); ?>';
            $.ajax({
                url: url_update,
                data: data_object,
                type: 'post',
                success: function(data, status, jqhr) {
                    if (transaction_status == 'settlement' || transaction_status == "capture") {
                        showToast('success', 'Pembayaran berhasil, silahkan tutup untuk cek QR Code Anda').then(result => {
                            if (result.dismiss) {
                                let qr_detail = data.qr_detail;
                                if (qr_detail.responseMessage == "success") {
                                    let urlQR = qr_detail.url_img;
                                    showImg(urlQR, 'QR Code', 'Order ID : <string>' + order_id + '</strong>').then(reloadAfterDismiss);
                                } else {
                                    window.location.reload();
                                }
                            }
                        });
                    } else if (transaction_status == 'pending') {
                        showToast('info', 'Silahkan melakukan pembayaran');
                        window.location.reload();
                    } else if (transaction_status == "deny" || transaction_status == "cancel") {
                        showError('Maaf, pembayaran ditolak');
                        window.location.reload();
                    } else if (transaction_status == "expire") {
                        showError('Maaf, pembayaran sudah melewati batas waktunya');
                        window.location.reload();
                    }
                }
            })
        }

        function reloadAfterDismiss(res) {
            if (res.dismiss) {
                window.location.reload();
            }
        }

        function get_status_payment_customer(order_id) {
            return get_encoded_server_key(order_id);
        }

        function get_encoded_server_key(order_id) {
            $.post('<?= base_url('api/get_server_key'); ?>', {
                order_id
            }, function(data, status, xhr) {
                if (data.statusMessage == 'success') {
                    let server_key = data.server_key;
                    status_payment(order_id, server_key);
                } else {
                    console.error('failed to retrieve data');
                }
            });
        }

        function ShowQRCustomerByOrderId(order_id = '') {
            $.ajax({
                url: '<?= base_url('api/getQRByOrderId'); ?>',
                type: 'post',
                data: {
                    order_id
                },
                success: (data, status, xhr) => {
                    if (data.statusMessage == 'success') {
                        showImg(data.url_img, 'QR Code');
                    }
                },
                error: (xhr, status, thrown) => {

                }
            })
        }

        function status_payment(order_id = '', encoded_server_key) {
            $.ajax({
                method: 'GET',
                url: `https://api.sandbox.midtrans.com/v2/${order_id}/status`,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Basic ' + encoded_server_key
                },
                async: true,
                success: (data, status, xhqr) => {
                    console.log(data);
                },
                error: (e) => console.log(e)
            });
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

        function formatNumber(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function check_no_reg(order_id, tos) {
            let url = "<?= base_url('api/check_no_reg'); ?>";
            var requestData = $.ajax({
                url,
                type: "GET",
                data: {
                    order_id,
                    tos
                },
                success: success_check_no_reg
            });
            return requestData;
        }

        function success_check_no_reg(data, status = "success", xhr) {
            $("#loading_check_no_registration").hide();
        }

        function getCheckNoRegistration() {
            $("#loading_check_no_registration").show();
            let order_id = $("#noRegistrationHasil").val();
            if (order_id != "") {
                let url = "<?= base_url('api/check_no_reg'); ?>";
                // $("#noRegistration2").hide();
                return check_no_reg(order_id, "registrasi_detail");
                // $.ajax({
                //     url,
                //     type: "GET",
                //     data: {
                //         order_id,
                //         tos: "registrasi_detail"
                //     },
                //     success: function(data, status, xhr) {

                //     }
                // });
            }
        }

        function getHasilNoRegistation() {
            let order_id = $("#noRegistration2").val();
            if (order_id != "") {
                let url = "<?= base_url('api/check_no_reg'); ?>";
                // $("#noRegistration2").hide();
                $.ajax({
                    url,
                    type: "GET",
                    data: {
                        order_id,
                        tos: "hasil"
                    },
                    success: function(data, status, xhr) {
                        console.table(data);
                        if (status == "ok") {
                            let status_cov = data.status_cov,
                                status_gen = data.status_gen,
                                status_orf = data.status_orf,
                                status_igg = data.status_igg,
                                status_igm = data.status_igm,
                                paket_pemeriksaan = data.paket_pemeriksaan,
                                nama_customer = data.nama_customer,
                                nik = data.nik,
                                tgl_kunjungan = data.tgl_kunjungan;
                        }
                    }
                });
            }
        }

        function getRescheduleNoRegistration() {
            let order_id = $("#noRegistration").val();
            if (order_id != "") {
                let url = "<?= base_url('api/check_no_reg'); ?>";
                // $("#noRegistration2").hide();
                $.ajax({
                    url,
                    type: "GET",
                    data: {
                        order_id,
                        tos: "reschedule"
                    },
                    success: function(data, status, xhr) {

                    }
                });
            }
        }
    </script>
    <?= $this->endSection(); ?>