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
            margin: 0;
            padding: 0;
        }

        html,
        body {
            font-family: 'Calibri' !important;
            font-size: 10pt !important;
        }
    </style>
</head>

<body>
    <header></header>
    <footer></footer>
    <main class="content">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-sm">
                    <tr>
                        <td>No. Reg/ Reg. No</td>
                        <td>:</td>
                        <td><?= $customer['customer_unique']; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm">
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><?= $customer['nama']; ?></td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td><?= $customer['nik']; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir/DOB</td>
                        <td>:</td>
                        <td><?= $customer['tanggal_lahir']; ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin/Sex</td>
                        <td>:</td>
                        <td><?= $customer['jenis_kelamin']; ?></td>
                    </tr>
                    <tr>
                        <td>Waktu Sampling</td>
                        <td>:</td>
                        <td><?= $detail_hasil['waktu_ambil_sampling']; ?></td>
                    </tr>
                    <tr>
                        <td>Waktu Periksa</td>
                        <td>:</td>
                        <td><?= $detail_hasil['waktu_periksa_sampling']; ?></td>
                    </tr>
                    <tr>
                        <td>Waktu Selesai</td>
                        <td>:</td>
                        <td><?= $detail_hasil['waktu_selesai_periksa']; ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm">
                    <tr>
                        <td>No. Passport</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Kewarganegaraan</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?= $customer['alamat']; ?></td>
                    </tr>
                    <tr>
                        <td>Faskes</td>
                        <td>:</td>
                        <td><?= $nama_faskes; ?></td>
                    </tr>
                    <tr>
                        <td>Kota</td>
                        <td>:</td>
                        <td><?= $city; ?></td>
                    </tr>
                    <tr>
                        <td>Instansi</td>
                        <td>:</td>
                        <td><?= $customer['nama_instansi']; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-sm" id="data_customer">
                    <thead>
                        <tr class="bg-primary">
                            <th>PEMERIKSAAN/TEST</th>
                            <th>HASIL/RESULT</th>
                            <th>BATAS NORMAL/NORMAL RANGE</th>
                            <th>METODE/METHOD</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>SARS-Cov-2</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>2019-nCov</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>VIC/N Gene</td>
                            <td></td>
                            <td>
                                <?= $detail_hasil['status_gene']; ?> (Cut off CT Value : <?= $detail_hasil['value_n_gene']; ?>)
                            </td>
                            <td>RT-PCR</td>
                        </tr>
                        <tr>
                            <td>FAM / ORF1ab</td>
                            <td></td>
                            <td><?= $detail_hasil['status_orf']; ?> (Cut off CT Value : <?= $detail_hasil['value_orf']; ?>)</td>
                            <td>RT-PCR</td>
                        </tr>
                        <tr>
                            <td>Interpretasi</td>
                            <td colspan="3">Result RT-PCR SARS-CoV-2: <?= $detail_hasil['status_cov']; ?></td>
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
            <li>Hasil pemeriksaan di atas dikerjakan dengan metode RT-PCR dan hanya menggambarkan kondisi saat pengambilan spesimen.</li>
            <li>Hasil PCR negatif tidak selalu berarti pasien tidak terinfeksi oleh pathogen, namun hanya menunjukkan bahwa material denetik pathogen tidak ditemukan di dalam
                sample.</li>
            <li>Jika hasil PCR positif atau timbul gejala klinis setelah pemeriksaan, silahkan hubungi dokter atau fasilitas kesehatan terdekat.</li>
            <li>Hasil PCR tidak dapat diandingkan antar satu laboratorium dengan laboratorium lain, karena perbedaan alat dan target gen yang digunakan.</li>
            <li>Surat ini dikirim dan ditandatangani secara elektronik.</li>
        </ol>
        note:
        <ol>
            <li>The above examination results were carried out using the RT-PCR method and only described the conditions at the time of specimen collection.</li>
            <li>A negative PCR result does not necessarily mean that the patient is not infected with the pathogen, but only indicates that pathogenic genetic material is not present
                in the sample.</li>
            <li>If the PCR result is positive or clinical symptoms appear after the examination, please contact the doctor or the nearest health facility.</li>
            <li>PCR results cannot be compared between one laboratory and another, due to differences in the tools and target genes used.</li>
            <li>This letter is sent and signed electronically</li>
        </ol>
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <td><i>QRCODE RESULT</i></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <td>South Jakarta, </td>
                    </tr>
                    <tr>
                        <td><i>Dokter Pemeriksa/Physician Examiner</i></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </main>
</body>

</html>