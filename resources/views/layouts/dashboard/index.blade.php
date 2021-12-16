@extends('layouts.home')

@section('content')    
    <h2 class="text-dark">Selamat Datang, {{ $username }}</h2>
    @role('Pendaftar')
        <h4 class="text-dark">Anda telah mendaftar pada event(s):</h4>
    @endrole

    <div class="card shadow my-2">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead align="center">
                        <tr>
                            <th>No.</th>
                            <th>Nama Event</th>
                            @role('Admin')
                                <th>Jumlah Peserta</th>
                            @else
                                <th>Waktu Pelaksanaan</th>
                                <th>Lokasi</th>
                                <th>Nama Pendaftar</th>
                                <th>Tanggal Mendaftar</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody align="center">
                        @role('Admin')
                            @foreach($datas as $data)
                            <tr>
                                <td width="50">{{$loop->iteration}}</td>
                                <td>{{$data->name}}</td>
                                <td>{{$data->pendaftaran->count()}}</td>
                            </tr>
                            @endforeach
                        @else
                            @foreach($datas as $data)
                            <tr>
                                <td width="50">{{$loop->iteration}}</td>
                                <td>{{$data->event->name}}</td>
                                <td>{{\Carbon\Carbon::parse($data->event->start_date)->isoFormat('D MMMM Y')}} s.d {{\Carbon\Carbon::parse($data->event->end_date)->isoFormat('D MMMM Y')}}</td>
                                <td>{{$data->event->lokasi}}</td>
                                <td>{{$data->nama_lengkap}}</td>
                                <td>{{$data->created_at}}</td>
                            </tr>
                            @endforeach
                        @endrole
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection