@php
    setlocale(LC_TIME, 'id_ID');
    \Carbon\Carbon::setLocale('id');
@endphp

<table>
    <tr>
        <td align="center" colspan="12"><b>DAFTAR HADIR KEGIATAN</b></td>
    </tr>
    <tr>
        <td align="center" colspan="12"><b>{{$data->name}}</b></td>
    </tr>
    <tr></tr>
    <tr>
        <td>Hari</td>
        <td></td>
        <td>: {{\Carbon\Carbon::parse($data->start_date)->isoFormat('dddd')}} - {{\Carbon\Carbon::parse($data->end_date)->isoFormat('dddd')}}</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td></td>
        <td>: {{\Carbon\Carbon::parse($data->start_date)->isoFormat('D MMMM Y')}} s/d {{\Carbon\Carbon::parse($data->end_date)->isoFormat('D MMMM Y')}}</td>
        <td></td>
        <td></td>
    </tr>
    {{-- <tr>
        <td>Tanggal Selesai Event</td>
        <td></td>
        <td>: {{\Carbon\Carbon::parse($data->end_date)->isoFormat('D MMMM Y')}}</td>
        <td></td>
        <td></td>
    </tr> --}}
    <tr>
        <td>Waktu</td>
        <td></td>
        <td>: {{\Carbon\Carbon::parse($data->start_date)->isoFormat('H:mm')}} - {{\Carbon\Carbon::parse($data->end_date)->isoFormat('H:mm')}}</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Tempat</td>
        <td></td>
        <td>: {{$data->lokasi}}</td>
        <td></td>
        <td></td>
    </tr>
</table>

<table>
    <tr>
        <th align="center">NO.</th>
        <th align="center">NIK</th>
        <th align="center">NAMA LENGKAP</th>
        <th align="center">NO HP</th>
        <th align="center">JENIS KELAMIN</th>
        <th align="center">TEMPAT, TANGGAL LAHIR</th>
        <th align="center">ALAMAT</th>
        <th align="center">TGL DAFTAR</th>
        <th align="center">NOMOR ANTRIAN</th>
        <th align="center">JENIS PENDAFTARAN</th>
        <th align="center">STATUS KEDATANGAN</th>
        <th align="center">STATUS KEBERHASILAN VAKSINASI</th>
    </tr>
    @foreach($data->pendaftaran as $pendaftar)
    <tr>
        <td align="center">{{$loop->iteration}}</td>
        <td align="center">{{$pendaftar->nik}}</td>
        <td align="center">{{$pendaftar->nama_lengkap}}</td>
        <td align="center">{{$pendaftar->no_hp}}</td>
        <td align="center">{{$pendaftar->jk}}</td>
        <td align="center">{{$pendaftar->tempat_lahir}}, {{\Carbon\Carbon::parse($pendaftar->tgl_lahir)->isoFormat('D MMMM Y')}}</td>
        <td align="center">{{$pendaftar->alamat}}</td>
        <td align="center">{{\Carbon\Carbon::parse($pendaftar->tgl_daftar)->isoFormat('D MMMM Y')}}</td>
        <td align="center">{{$pendaftar->nomor_antrian}}</td>
        <td align="center">{{$pendaftar->jenis_pendaftaran}}</td>
        <td align="center">{{$pendaftar->status_kedatangan == 1 ? 'Datang' : 'Tidak Datang'}}</td>
        <td align="center">{{$pendaftar->status_keberhasilan_vaksinasi == 1 ? 'Berhasil Vaksin' : 'Gagal Vaksin'}}</td>
    </tr>
    @endforeach
</table>

<table>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="center">Pontianak, {{\Carbon\Carbon::today()->isoFormat('D MMMM Y')}}</td>
    </tr>
    <tr></tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="center">Pembuat Daftar,</td>
    </tr>
    <tr></tr><tr></tr><tr></tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="center">{{\Auth::user()->name}}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="center" style="color: red;">{{\Auth::user()->name}}</td>
    </tr>
</table>
