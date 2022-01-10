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
                                <th>Actions</th>
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
                                <td>{{\Carbon\Carbon::parse($data->event->start_date)->isoFormat('D MMMM Y HH:mm')}} s.d {{\Carbon\Carbon::parse($data->event->end_date)->isoFormat('D MMMM Y HH:mm')}}</td>
                                <td>{{$data->event->lokasi}}</td>
                                <td>{{$data->nama_lengkap}}</td>
                                <td>{{$data->created_at}}</td>
                                <td>
                                    {{-- Tombol Download Formulir Pemberian Vaksinasi COVID-19 --}}
                                    <span>
                                        <button type="button" data-toggle="modal" data-target="#download-{{$data->id}}" class="btn btn-danger m-1">
                                            <i class="fas fa-file-pdf text-light"></i>
                                        </button>

                                        {{-- Download Modal --}}
                                        <div class="modal fade" id="download-{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Download Confirmation</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-left">
                                                        Are you sure to download Formulir Pemberian Vaksinasi COVID-19 {{$data->nama_lengkap}} ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <form method="GET" action="{{ route('pendaftaran.formulir_pendaftaran', ['event_id', $data->event_id, 'pendaftaran_id' => $data->id]) }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Download</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        @endrole
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection