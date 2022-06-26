<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{$file_name}}</title>
    <style>
        body {
            font-size: 12px;
            word-spacing: 0;
            line-height: 12px;
        }

        .judul {
            text-align: center;
            font-weight: bold;
        }

        .praregis {
            width: 100%;
            border-collapse: collapse;
        }
        .praregis .paraf {
            border: 1px solid black;
        }

        .vaksinasi {
            width: 100%;
            border-collapse: collapse;
        }
        .vaksinasi td, {
            border: 1px solid black;
        }

        .hasil-skrining {
            width: 100%;
            border-collapse: collapse;
        }
        .hasil-skrining tbody {
            border: 1px solid black;
        }

        .hasil-vaksinasi {
            width: 100%;
            border-collapse: collapse;
        }
        .hasil-vaksinasi tbody {
            border: 1px solid black;
        }

        .pencatatan {
            width: 100%;
            border-collapse: collapse;
        }
        .pencatatan tbody {
            border: 1px solid black;
        }
        .page-break {
            page-break-after: always;
        }

        .halaman-2 {
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="judul">FORMULIR PEMBERIAN VAKSINASI COVID-19</div><br>
    <table class="praregis">
        <thead>
            <tr>
                <th colspan="6" align="left">A. MEJA PRA REGISTRASI</th>
                <th class="paraf" style="border-bottom: none;">Paraf petugas</th>
            </tr>
            <tr>
                <th width="130" align="left">Nama Penerima Vaksin</th>
                <th colspan="2" align="left">: {{$pendaftar->nama_lengkap}}</th>
                <th colspan="2" align="left">Kelompok Umur</th>
                <th></th>
                <th class="paraf" style="border-top: none; border-bottom: none;"></th>
            </tr>
            <tr>
                <th width="130" align="left">NIK</th>
                <th colspan="2" align="left">: {{$pendaftar->nik}}</th>
                <th colspan="2" align="left">&lt;50Tahun</th>
                <th><input type="checkbox" @if($kategori_umur == 1) {{'checked'}} @endif></th>
                <th class="paraf" style="border-top: none; border-bottom: none;"></th>
            </tr>
            <tr>
                <th width="130" align="left">No. HP</th>
                <th colspan="2" align="left">: {{$pendaftar->no_hp}}</th>
                <th colspan="2" align="left">50-60Tahun</th>
                <th><input type="checkbox" @if($kategori_umur == 2) {{'checked'}} @endif></th>
                <th class="paraf" style="border-top: none; border-bottom: none;"></th>
            </tr>
            <tr>
                <th width="130" align="left">Jenis Kelamin</th>
                <th colspan="2" align="left">: {{$pendaftar->jk}}</th>
                <th colspan="2" align="left">&gt;50-60Tahun</th>
                <th><input type="checkbox" @if($kategori_umur == 3) {{'checked'}} @endif></th>
                <th class="paraf" style="border-top: none; border-bottom: none;"></th>
            </tr>
            <tr>
                <th width="130" align="left">T.T.L/Umur</th>
                <th colspan="2" align="left" style="font-size: 12px;">: {{$pendaftar->tempat_lahir}} / {{$pendaftar->tgl_lahir}}</th>
                <th colspan="2" align="left"></th>
                <th></th>
                <th class="paraf" style="border-top: none;"></th>
            </tr>
            <tr>
                <th width="130" align="left">Alamat</th>
                <th colspan="2" align="left" style="font-size: 12px;">: {{$pendaftar->alamat}}</th>
                <th colspan="2" align="left">Lokasi Menerima</th>
                <th>:</th>
                <th style="font-size: 12px;">Yayasan Pemadam Kebakaran Panca Bhakti</th>
            </tr>
        </thead>
    </table>
    <hr>
    <table class="vaksinasi">
        <thead>
            <tr>
                <th colspan="5" align="left" style="padding-top: 10px;">B. MEJA 1 (SKRINING DAN VAKSINASI)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th colspan="5" style="border: 1px solid black;">SKRINING</th>
            </tr>
            <tr>
                <td align="center">No.</td>
                <td align="center">Pemeriksaan</td>
                <td align="center" colspan="2">Hasil</td>
                <td align="center">Tindak Lanjut</td>
            </tr>
            <tr>
                <td align="center">1</td>
                <td>Suhu</td>
                <td colspan="2"></td>
                <td>Suhu > 37,5 &deg;C vaksinasi ditunda sampai sasaran sembuh</td>
            </tr>
            <tr>
                <td align="center">2</td>
                <td>Tekanan Darah</td>
                <td colspan="2"></td>
                <td>Jika Tekanan Darah &gt;= 180/110 mmHg. Pengukuran Tekanan Darah Diulang 5(lima) sampai 10(sepuluh) menit kemudian. Jika masih tinggi maka Vaksinasi ditunda sampai terkontrol</td>
            </tr>
            <tr>
                <td></td>
                <td align="center">Pertanyaan</td>
                <td>Ya</td>
                <td>Tidak</td>
                <td></td>
            </tr>
            <tr>
                <td align="center">1</td>
                <td>
                    Pertanyaan untuk vaksinasi ke-1<br>
                    Apakah Anda memiliki riwayat alergi berat seperti sesak napas, bengkak dan urtikaria seluruh badan atau reaksi berat lainnya karena vaksin?
                </td>
                <td></td>
                <td></td>
                <td>Jika Ya: vaksinasi diberikan di Rumah Sakit</td>
            </tr>
            <tr>
                <td></td>
                <td>
                    Pertanyaan untuk vaksinasi ke-2<br>
                    Apakah Anda memiliki riwayat alergi berat setelah divaksinasi COVID-19 sebelumnya?
                </td>
                <td></td>
                <td></td>
                <td>Jika Ya: merupakan kontraindikasi untuk vaksinasi ke-2</td>
            </tr>
            <tr>
                <td align="center">2</td>
                <td>Apakah Anda sedang hamil?</td>
                <td></td>
                <td></td>
                <td>Jika sedang hamil vaksinasi ditunda sampai melahirkan</td>
            </tr>
            <tr>
                <td align="center">3</td>
                <td>Apakah Anda mengidap penyakit autoimun seperti asma, lupus.</td>
                <td></td>
                <td></td>
                <td>Jika Ya: vaksinasi ditunda jika sedang dalam kondisi akut atau belum terkendali</td>
            </tr>
            <tr>
                <td align="center">4</td>
                <td>Apakah Anda sedang mendapat pengobatan untuk gangguan pembekuan darah, kelainan darah, defisiensi imun dan penerima produk darah/transfusi?</td>
                <td></td>
                <td></td>
                <td>Jika Ya: vaksinasi ditunda dan dirujuk</td>
            </tr>
            <tr>
                <td align="center">5</td>
                <td>Apakah Anda sedang mendapat pengobatan immunosupressant seperti kortikosteroid dan kemoterapi?</td>
                <td></td>
                <td></td>
                <td>Jika Ya: vaksinasi ditunda dan dirujuk</td>
            </tr>
            <tr>
                <td align="center">6</td>
                <td>Apakah Anda memiliki penyakit jantung berat dalam keadaan sesak?</td>
                <td></td>
                <td></td>
                <td>Jika Ya: vaksinasi ditunda dan dirujuk</td>
            </tr>
            <tr>
                <td colspan="5" style="padding-top: 5px; padding-bottom: 5px;">Pertanyaan Nomor 7 dilanjutkan apabila terdapat penilaian kelemahan fisik pada sasaran vaksinasi.</td>
            </tr>
            <tr>
                <td align="center">7</td>
                <td>
                    Pertanyaan tambahan bagi sasaran lansia (>= 60 tahun):<br>
                    1. Apakah Anda mengalami kesulitan untuk naik 10 anak tangga?<br>
                    2. Apakah Anda sering merasa kelelahan?<br>
                    3. Apakah Anda memiliki 5 atau lebih dari 11 penyakit berikut (Hipertensi, diabetes, kanker, penyakit paru kronis, serangan jantung, gagal jantung kongestif, nyeri dada, asma, nyeri sendi, stroke dan penyakit ginjal)?<br>
                    4. Apakah Anda mengalami kesulitan berjalan kira-kira 100 sampai 200 meter?<br>
                    5. Apakah Anda mengalami penurunan berat badan yang bermakna dalam setahun terakhir?
                </td>
                <td></td>
                <td></td>
                <td>Jika terdapat 3 atau lebih jawaban Ya maka vaksin tidak dapat diberikan</td>
            </tr>
        </tbody>
    </table>

    <table class="hasil-skrining">
        <tbody>
            <tr>
                <td colspan="4">HASIL SKRINING</td>
                <td width="195" style="border-left: 1.5px solid black; padding-left: 20px;">Paraf petugas</td>
            </tr>
            <tr>
                <td colspan="4" style="vertical-align: middle;">
                    <input id="lanjut_vaksin" type="checkbox">
                    <label for="lanjut_vaksin">LANJUT VAKSIN</label>
                </td>
                <td width="209" style="border-left: 1.5px solid black;"></td>
            </tr>
            <tr>
                <td colspan="4"><input type="checkbox" style="padding-top: 5px;"> TUNDA</td>
                <td width="209" style="border-left: 1.5px solid black;"></td>
            </tr>
            <tr>
                <td colspan="4"><input type="checkbox" style="padding-top: 5px;"> TIDAK DIBERIKAN</td>
                <td width="209" style="border-left: 1.5px solid black;"></td>
            </tr>
        </tbody>
    </table>

    <table class="hasil-vaksinasi">
        <tbody>
            <tr>
                <td colspan="5" style="padding-top: 5px; padding-bottom: 5px; border-bottom: 1px solid black;">HASIL VAKSINASI</td>
            </tr>
            <tr>
                <td style="padding-left: 20px; border-right: 1px solid black;" width="100">Jenis Vaksin:</td>
                <td colspan="3"></td>
                <td width="195" style="border-left: 1px solid black; padding-left: 20px;">Paraf petugas</td>
            </tr>
            <tr>
                <td style="padding-left: 20px; border-right: 1px solid black;">No. Batch:</td>
                <td colspan="3"></td>
                <td width="209" style="border-left: 1px solid black;"></td>
            </tr>
            <tr>
                <td style="padding-left: 20px; border-right: 1px solid black;">Tanggal vaksinasi:</td>
                <td colspan="3"></td>
                <td width="209" style="border-left: 1px solid black;"></td>
            </tr>
            <tr>
                <td style="padding-left: 20px; border-right: 1px solid black;">Jam Vaksinasi:</td>
                <td colspan="3"></td>
                <td width="209" style="border-left: 1px solid black;"></td>
            </tr>
        </tbody>
    </table>

    <table class="pencatatan">
        <thead>
            <tr>
                <th colspan="5" align="left" style="padding-top: 5px; padding-bottom: 5px;">C. Meja 2: PENCATATAN DAN OBSERVASI</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5" style="border-bottom: 1px solid black;">HASIL OBSERVASI</td>
            </tr>
            <tr>
                <td colspan="4"><input type="checkbox"> Tanpa keluhan</td>
                <td width="195" style="border-left: 1px solid black; padding-left: 20px;">Paraf petugas</td>
            </tr>
            <tr>
                <td colspan="4">
                    <input type="checkbox">Ada keluhan<br>
                    <div style="padding-left: 16px; padding-bottom: 50px;">Sebutkan keluhan jika ada,........<div>
                </td>
                <td style="border-left: 1px solid black;"></td>
            </tr>
        </tbody>
    </table>
    <p>
        Dengan ini menyatakan SETUJU untuk menerima vaksin Covid-19 (dosis pertama / kedua)<br>
        Dari penjelasan yang diberikan, saya memahami manfaat, tindakan yang dilakukan, dosis dan kemungkinan paska tindakan yang mungkin terjadi sesuai penjelasan yang diberikan
    </p>
    <div align="right" style="padding-right: 70px;">Pemohon</div>
    <div align="right" style="padding-right: 40px; padding-top: 60px;">({{$pendaftar->nama_lengkap}})</div>

    {{-- Halaman Kedua --}}
    <div class="page-break"></div>
    <br>
    <div class="halaman-2">
        <p>Yth. {{$pendaftar->nama_lengkap}} terima kasih telah melakukan pendaftaran vaksin di {{$pendaftar->event->lokasi}} pada tanggal {{\Carbon\Carbon::parse($pendaftar->event->start_date)->isoFormat('D MMMM Y')}} - {{\Carbon\Carbon::parse($pendaftar->event->end_date)->isoFormat('D MMMM Y')}}.</p>
        <br>
        <p>Nomor Pendaftaran anda:</p>
        <h2>{{$pendaftar->nomor_antrian}}</h2>
        <br>
        <p>Anda diharapkan dapat hadir pada jam</p>
        <h2>{{$rentang_waktu}}</h2>
        <br>
        <p>Dan juga membawa dokumen kelengkapan lainnya:</p>
        <p style="margin-left: 10px;">1. Fotokopi KTP</p>
        <p style="margin-left: 10px;">2. Sertifikat vaksin (jika sudah pernah melakukan vaksinasi)</p>
        <p style="margin-left: 10px;">3. Formulir Pemberian Vaksinasi COVID-19</p>
    </div>
</body>
</html>