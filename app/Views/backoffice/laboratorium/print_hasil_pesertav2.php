<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:url" content="https://quicktest.id" />

    <title><?= $title; ?>.pdf</title>
    <style>
        <?= $this->include('backoffice/template/adminlte.min.css'); ?>

        /** */
        @page {
            margin: 0cm 0cm;
        }

        html,
        body {
            font-family: 'Bergens' !important;
            font-size: 8pt !important;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 3cm;
            margin-left: 0cm;
            margin-right: 0cm;
            margin-bottom: 0cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }
    </style>
</head>

<body>
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td class="pb-4">
                                <img src="<?= base_url('assets/images/logo-warna.png') ?>" alt="" width="350">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong><i>PT. QUICKTEST LABORATORIUM INDONESIA</i></strong>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </header>
    <footer>
        <table class="table table-borderless table-sm text-primary">
            <tr>
                <td><img src="<?= base_url('assets/icons/icon reg.quicktest.id_Mail.svg'); ?>" alt="mail"> info@quicktest.id</td>
            </tr>
            <tr>
                <td><img src="<?= base_url('assets/icons/icon reg.quicktest.id_Call.png'); ?>" alt="phone"> 021-2138999 (for result)</td>
            </tr>
            <tr>
                <td></td>
            </tr>
        </table>
    </footer>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="25%">Pemeriksa/<i>Investigator</i></td>
                            <td>: <?= $customer['customer_unique']; ?></td>
                        </tr>
                        <tr>
                            <td>Dokter/<i>Doctor</i></td>
                            <td>: <?= $doctor_name; ?></td>
                        </tr>
                        <tr>
                            <td>No. Reg/<i>Reg. No</i></td>
                            <td>: <?= $customer['customer_unique']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td>Nama</td>
                            <td>: <?= $customer['nama']; ?></td>
                            <td>Kewarganegaraan</td>
                            <td>: </td>
                        </tr>
                        <tr>
                            <td>NIK</td>
                            <td>: <?= $customer['nik']; ?></td>
                            <td>Alamat</td>
                            <td rowspan="3">: <?= $customer['alamat']; ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir/DOB</td>
                            <td>: <?= date("F, d Y", strtotime($customer['tanggal_lahir'])); ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin/Sex</td>
                            <td>: <?= ucwords($customer['jenis_kelamin']); ?></td>
                        </tr>
                        <tr>
                            <td>Waktu Sampling</td>
                            <td>: <?= date("F,d Y", strtotime($detail_hasil['waktu_ambil_sampling'])); ?></td>
                            <td>Faskes</td>
                            <td>: <?= $nama_faskes; ?></td>
                        </tr>
                        <tr>
                            <td>Waktu Periksa</td>
                            <td>: <?= date("F, d Y", strtotime($detail_hasil['waktu_periksa_sampling'])); ?></td>
                            <td>Kota/<i>City</i></td>
                            <td>: <?= $city; ?></td>
                        </tr>
                        <tr>
                            <td>Waktu Selesai</td>
                            <td>: <?= date("F, d Y", strtotime($detail_hasil['waktu_selesai_periksa'])); ?></td>
                            <td>Instansi</td>
                            <td>: <?= ucwords($customer['nama_instansi']); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-borderless table-sm" style="border: 1pt solid #333;" id="data_customer">
                        <thead>
                            <tr class="text-center" style="background-color: #1a428a; color: white">
                                <th>PEMERIKSAAN/TEST</th>
                                <th>HASIL/RESULT</th>
                                <th>BATAS NORMAL/NORMAL RANGE</th>
                                <th>METODE/METHOD</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #b8d8eb">
                            <tr>
                                <td><strong>Anti SARS-CoV-2 IgM</strong></td>
                                <td></td>
                                <td><?= $detail_hasil['status_igg']; ?></td>
                                <td></td>
                            </tr>
<<<<<<< HEAD
                            <tr>
                                <td>Anti SARS-CoV-2 IgG</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
=======
>>>>>>> 9b838b41ea9ab9a5e747338ff150084b6e5feada
                            <tr class="bg-light">
                                <td>Interpretasi</td>
                                <td colspan="3">Result Anti SARS-CoV-2: <?= $detail_hasil['status_cov']; ?></td>
                            </tr>
                            <tr>
                                <td>Rekomendasi</td>
                                <td colspan="3"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <h4>DISCLAIMER:</h4>
            Catatan: <br>
            <ol>
                <li>Hasil pemeriksaan di atas dikerjakan dengan metode Swab Antigen dan hanya menggambarkan kondisi saat pengambilan spesimen.</li>
                <li>Hasil PCR negatif tidak selalu berarti pasien tidak terinfeksi oleh pathogen, namun hanya menunjukkan bahwa material denetik pathogen tidak ditemukan di dalam
                    sample.</li>
                <li>Jika hasil PCR positif atau timbul gejala klinis setelah pemeriksaan, silahkan hubungi dokter atau fasilitas kesehatan terdekat.</li>
                <li>Hasil PCR tidak dapat diandingkan antar satu laboratorium dengan laboratorium lain, karena perbedaan alat dan target gen yang digunakan.</li>
                <li>Surat ini dikirim dan ditandatangani secara elektronik.</li>
            </ol>
            note:
            <ol>
                <li>The above examination results were carried out using the Antigen Swab method and only described the conditions at the time of specimen collection.</li>
                <li>A negative Antigen Swab result does not necessarily mean that the patient is not infected with the pathogen, but only indicates that pathogenic genetic material is not present
                    in the sample.</li>
                <li>If the PCR result is positive or clinical symptoms appear after the examination, please contact the doctor or the nearest health facility.</li>
                <li>Antigen Swab results cannot be compared between one laboratory and another, due to differences in the tools and target genes used.</li>
                <li>This letter is sent and signed electronically</li>
            </ol>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-center">QRCODE RESULT<br>
                                <img src="<?= $image_qr_result ?>" alt="">
                            </td>
                            <td class="text-center"><?= $city; ?>, <?= $sign_waktu; ?><br>

                                Dokter Pemeriksa/<i>Physician Examiner</i>
                                <br>
                                <?= $doctor_name; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>

</html>