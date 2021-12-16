@php
    setlocale(LC_TIME, 'id_ID');
    \Carbon\Carbon::setLocale('id');
@endphp

@if($sheet == 0)
<table>
    <tr>
        <td align="center" colspan="10"><b>DAFTAR PENERIMA TRANSPORT</b></td>
    </tr>
    <tr>
        <td align="center" colspan="10"><b>{{$data->name}}</b></td>
    </tr>
    <tr>
        <td align="center" colspan="10"><b>PADA TANGGAL {{\Carbon\Carbon::parse($data->start_date)->isoFormat('D MMMM Y')}} s/d {{\Carbon\Carbon::parse($data->end_date)->isoFormat('D MMMM Y')}}</b></td>
    </tr>
    <tr>
        <td align="center" colspan="10"><b>DI {{$data->lokasi}}</b></td>
    </tr>
    <tr>
        <td align="center" colspan="10"><b>(SESUAI SURAT TUGAS TERLAMPIR)</b></td>
    </tr>
    <tr></tr>
</table>

<table>
    <tr>
        <th align="center">NO.</th>
        <th align="center">NAMA</th>
        <th align="center">GOL</th>
        <th align="center">JABATAN/INSTANSI</th>
        <th align="center">RINCIAN TRANSPORT</th>
        <th align="center">JUMLAH DITERIMA</th>
        <th align="center">NAMA BANK</th>
        <th align="center">NO. REKENING BANK</th>
        <th align="center" colspan="2">TANDA TANGAN</th>
    </tr>
    @foreach($data->pendaftaran as $pendaftar)
    <tr>
        <td align="center">{{$loop->iteration}}</td>
        <td align="center">{{$pendaftar->nama_lengkap}}</td>
        <td align="center">{{$pendaftar->jabatan}}</td>
        <td align="center">{{$pendaftar->instansi}} {{$pendaftar->kabupaten->nama_kabupaten}}</td>
        <td align="center">1 OT x Rp {{number_format($pendaftar->biaya_perjalanan, 0, '.')}}</td>
        <td align="center">Rp {{number_format($pendaftar->biaya_perjalanan, 0, '.')}}</td>
        <td align="center">{{$pendaftar->nama_bank}}</td>
        <td align="center">{{$pendaftar->no_rekening}}</td>
        <td>{{$loop->iteration % 2 != 0 ? $loop->iteration.'.  .................................' : ''}}</td>
        <td>{{$loop->iteration % 2 == 0 ? $loop->iteration.'.  .................................' : ''}}</td>
    </tr>
    @endforeach
</table>
@else
<table>
    <tr>
        <td align="center" colspan="6"><b>DAFTAR HADIR KEGIATAN</b></td>
    </tr>
    <tr>
        <td align="center" colspan="6"><b>{{$data->name}}</b></td>
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
        <th align="center">NAMA</th>
        <th align="center">JABATAN</th>
        <th align="center">INSTANSI</th>
        <th align="center" colspan="2">TANDA TANGAN</th>
    </tr>
    @foreach($data->pendaftaran as $pendaftar)
    <tr>
        <td align="center">{{$loop->iteration}}</td>
        <td align="center">{{$pendaftar->nama_lengkap}}</td>
        <td align="center">{{$pendaftar->jabatan}}</td>
        <td align="center">{{$pendaftar->instansi}} {{$pendaftar->kabupaten->nama_kabupaten}}</td>
        <td>{{$loop->iteration % 2 != 0 ? $loop->iteration.'.  .................................' : ''}}</td>
        <td>{{$loop->iteration % 2 == 0 ? $loop->iteration.'.  .................................' : ''}}</td>
    </tr>
    @endforeach
</table>

<table>
    <tr>
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
        <td align="center">Pembuat Daftar,</td>
    </tr>
    <tr></tr><tr></tr><tr></tr>
    <tr>
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
        <td align="center" style="color: red;">NIP. {{\Auth::user()->nip}}</td>
    </tr>
</table>
@endif
