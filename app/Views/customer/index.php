<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-lg-3">&nbsp;</div>
        <div class="col-lg-9">
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
                            <button class="btn btn-primary" type="button" id="btnSearchReschedule">Cari</button>
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
                            <button class="btn btn-primary" type="button" id="btnSearchCheckReg">Cari</button>
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
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $midtrans_client_key; ?>"></script>
<script>
    var id_jenis_test, nama_jenis_test, jam_kunjungan, token_client;
    $(document).ready(() => {
        getMenu();
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
            $.each(e, (i, v) => {
                menus += `<div class="col-lg-4 my-3">
                    <div class="card" onclick="modalRegistrasi(${v.id_jenis_test})">
                        <div class="card-body">
                            <h5 class="card-title text-center">${v.keterangan}</h5>
                            <img src="<?= base_url('assets'); ?>/${v.img_url}" class="card-img-top" alt="${v.keterangan}">
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-outline-primary btn-block">CHECK OUT</a>
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
            id_jenis_test: id_jenis_test
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
        var midtransToken;
        $.post(url_post_registration, dataSend).then((data, status) => {
            if (status == "success") {
                console.log('STATUS', status);
                let midtrans_return = data.data.data;
                midtransToken = midtrans_return.token;
                let invoice_number = data.invoice_number;
                let transaction = data.transaction;
                console.log('midtrans return : ', midtrans_return);
                console.log('invoice number : ', invoice_number);
                console.log('transaction detail : ', transaction);
                $("#registrasi, #backForm").addClass("disabled");
                $("#registrasi").html(`Loading..<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`);
                snap.pay(midtransToken, {
                    onSuccess: result => {
                        location.reload();
                    },
                    onPending: result => {
                        location.reload();
                    },
                    onError: result => {
                        location.reload();
                    },
                    onClose: () => {
                        location.reload();
                    }
                });
            }
            // snap.show();
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

    function formatNumber(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>
<?= $this->endSection(); ?>