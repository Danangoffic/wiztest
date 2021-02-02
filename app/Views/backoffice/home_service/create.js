var tgl_kunjungan, jam_kunjungan,
    pemeriksa, paket_pemeriksaan,
    id_pemeriksaan, nik,
    nama, jenis_kelamin,
    tempat_lahir, tanggal_lahir,
    phone, email,
    alamat, faskes_asal,
    instansi, id_marketing,
    biaya,
    status_pembayaran, catatan, nama_paket_pemeriksaan, harga_selected;
var array_peserta = [];
$(document).ready(function() {
    $("select").addClass("select2");
    $("select").select2({
        theme: "bootstrap4",
        width: "100%"
    });
    detail_data_test();
    tgl_kunjungan = $("#tgl_kunjungan"), jam_kunjungan = $("#jam_kunjungan"),
        pemeriksa = $("#pemeriksa"), paket_pemeriksaan = $("#paket_pemeriksaan"),
        id_pemeriksaan = $("#id_pemeriksaan"), nik = $("#nik"), nama = $("#nama"),
        jenis_kelamin = $("[name=jenis_kelamin]"), tempat_lahir = $("#tempat_lahir"), tanggal_lahir = $("#tanggal_lahir"),
        phone = $("#phone"), email = $("#email"), alamat = $("#alamat"), faskes_asal = $("#faskes_asal"), instansi = $("#instansi"),
        id_marketing = $("#id_marketing"), status_pembayaran = $("#status_pembayaran"), catatan = $("#catatan"),
        nama_paket_pemeriksaan = $("#paket_pemeriksaan").find("option:selected").text();
    document.getElementById("simpan").addEventListener("click", simpan_peserta, false);
});

function tambah_peserta() {
    let validasi = validasi_add_peserta();


    if (validasi) {
        let peserta = {
            tgl_kunjungan: tgl_kunjungan.val(),
            jam_kunjungan: jam_kunjungan.val(),
            pemeriksa: pemeriksa.val(),
            paket_pemeriksaan: paket_pemeriksaan.val(),
            id_pemeriksaan: id_pemeriksaan.val(),
            nik: nik.val(),
            nama: nama.val(),
            jenis_kelamin: jenis_kelamin.val(),
            tempat_lahir: tempat_lahir.val(),
            tanggal_lahir: tanggal_lahir.val(),
            phone: phone.val(),
            email: email.val(),
            faskes_asal: faskes_asal.val(),
            instansi: instansi.val(),
            id_marketing: id_marketing.val(),
            status_pembayaran: status_pembayaran.val(),
            catatan: catatan.val(),
            nama_paket_pemeriksaan
        };
        array_peserta.push(peserta);
    }
}

function reset_forms() {
    tgl_kunjungan.val(""),
        jam_kunjungan.val(""),
        pemeriksa.val(""),
        paket_pemeriksaan.val(""),
        id_pemeriksaan.val(""),
        nik.val(""),
        nama.val(""),
        jenis_kelamin.val(""),
        tempat_lahir.val(""),
        tanggal_lahir.val(""),
        phone.val(""),
        email.val(""),
        faskes_asal.val(""),
        instansi.val(""),
        id_marketing.val(""),
        status_pembayaran.val(""),
        catatan.val("");
}

function validasi_add_peserta() {
    if (nik.val() == "" || nik.val() == null || nik.val().length == 0 || nik.val() == 0) {
        showError('NIK Wajib Diisi');
        return false;
    } else if (nik.val().length < 16) {
        showError('NIK Wajib Diisi dengan 16 angka');
        return false;
    }

    if (nama.val() == "" || nama.val() == null || nama.val().length == 0) {
        showError('Nama Lengkap Wajib Diisi');
        return false;
    }

    if (phone.val() == "" || phone.val() == null || phone.val().length == 0) {
        showError('Nomor WhatsApp Wajib diisi');
        return false;
    }

    if (phone.val() != confirmPhone) {
        showError('Nomor WhatsApp harus sesuai dengan Nomor Konfirmasi WhatsApp');
        return false;
    }

    if (email.val() == "" || email.val() == null) {
        showError('Email wajib diisi');
        return false;
    }

    if (jenis_kelamin.val() == "" || jenis_kelamin.val() == undefined || jenis_kelamin.val() == null) {
        showError('Jenis kelamin wajib diisi');
        return false;
    }
    if (tempat_lahir.val() == "" || tempat_lahir.val() == undefined || tempat_lahir.val() == null) {
        showError('Tempat lahir wajib diisi');
        return false;
    }
    if (tgl_lahir.val() == "" || tgl_lahir.val() == null || tgl_lahir.val() == undefined) {
        showError('Tanggal lahir wajib diisi');
        return false;
    }
    if (alamat.val() == "" || alamat.val() == null || alamat.val() == undefined) {
        showError('Alamat lengkap wajib diisi');
        return false;
    }
    if (id_marketing.val() == "" || id_marketing.val() == null || id_marketing.val() == undefined) {
        showError('Marketing wajib dipilih');
        return false;
    }
    return true;
}

function detail_data_test() {
    let val_paket_pemeriksaan = $("#paket_pemeriksaan").val();
    $.get("<?= base_url('api/detail-paket-pemeriksaan'); ?>?id_paket_pemeriksaan=" + val_paket_pemeriksaan + "segmen=2", function(data) {
        harga_selected = data.biaya;
    });
}

function show_peserta_table() {
    let html_table = "";
    $.each(array_peserta, (k, v) => {
        html_table += `<tr id="peserta${k}">
        <td>${v.nama}</td>
        <td>${v.nik}</td>
        <td>${v.nama_layanan} ${v.nama_test}</td>
        <td>${v.biaya}</td>
        <td><button class="btn btn-sm btn-danger btn-icon" type="button" role="button" onclick="return remove_peserta(${k})"><i class="icon fas fa-trash"></i></button></td>
        </tr>`;
    });
    $("#result_peserta").html(html_table);
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