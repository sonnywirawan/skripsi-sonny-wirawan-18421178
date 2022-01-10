@extends('layouts.home')

@section('content')
    <h3 class="text-dark text-center">{{$event->name}}</h3>
    <h4 class="text-center"><b>PADA TANGGAL {{\Carbon\Carbon::parse($event->start_date)->isoFormat('D MMMM Y')}} s/d {{\Carbon\Carbon::parse($event->end_date)->isoFormat('D MMMM Y')}}</b></h4>

    <div id="app" class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">Pendaftaran Datatable</h6>
                </div>
                <div class="col text-right">
                    <a href="{{ route('pendaftaran.form', ['event_id' => $event_id]) }}" role="button" class="btn bg-gradient-primary text-white">Add New Pendaftar</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead align="center">
                        <tr>
                            <th>No.</th>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>No. HP</th>
                            <th>Jenis Kelamin</th>
                            <th>Tempat / Tgl Lahir</th>
                            <th>Alamat</th>
                            <th>Tgl Daftar</th>
                            <th>Nomor Antrian</th>
                            <th>Jenis Pendaftaran</th>
                            <th>Status Kedatangan</th>
                            <th>Status Keberhasilan Vaksin</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        @foreach($pendaftaran as $pendaftar)
                        <tr>
                            <td width="50">{{$loop->iteration}}</td>
                            <td>{{$pendaftar['nik']}}</td>
                            <td>{{$pendaftar['nama_lengkap']}}</td>
                            <td>{{$pendaftar['no_hp']}}</td>
                            <td>{{$pendaftar['jk']}}</td>
                            <td>{{$pendaftar['tempat_lahir']}} / {{$pendaftar['tgl_lahir']}}</td>
                            <td>{{$pendaftar['alamat']}}</td>
                            <td>{{$pendaftar['tgl_daftar']}}</td>
                            <td>{{$pendaftar['nomor_antrian']}}</td>
                            <td>{{$pendaftar['jenis_pendaftaran']}}</td>
                            <td>
                                @if($pendaftar->status_kedatangan == 0)
                                    <i class="fas fa-times fa-2x text-danger">
                                @else
                                    <i class="fas fa-check fa-2x text-success">
                                @endif
                            </td>
                            <td>
                                @if($pendaftar->status_keberhasilan_vaksinasi == 0)
                                    <i class="fas fa-times fa-2x text-danger">
                                @else
                                    <i class="fas fa-check fa-2x text-success">
                                @endif
                            </td>
                            <td width="150">
                                {{-- Tombol Edit --}}
                                <span>
                                    <a href="{{ route('pendaftaran.form', ['event_id' => $event_id, 'pendaftaran_id' => $pendaftar->id]) }}" role="button" class="btn btn-warning">
                                        <i class="fas fa-edit text-light"></i>
                                    </a>
                                </span>
                                {{-- Tombol Delete --}}
                                <span>
                                    <button type="button" data-toggle="modal" data-target="#delete-{{$pendaftar->id}}" class="btn btn-danger m-1">
                                        <i class="fas fa-trash text-light"></i>
                                    </button>

                                    {{-- Delete Modal --}}
                                    <div class="modal fade" id="delete-{{$pendaftar->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-left">
                                                    Are you sure to delete {{$pendaftar->nama_lengkap}} ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <form method="POST" action="{{ route('pendaftaran.delete', ['event_id' => $event_id, 'pendaftaran_id' => $pendaftar->id]) }}">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </span>

                                {{-- Tombol Download Formulir Pemberian Vaksinasi COVID-19 --}}
                                <span>
                                    <button type="button" data-toggle="modal" data-target="#download-{{$pendaftar['id']}}" class="btn btn-danger m-1">
                                        <i class="fas fa-file-pdf text-light"></i>
                                    </button>

                                    {{-- Download Modal --}}
                                    <div class="modal fade" id="download-{{$pendaftar['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Download Confirmation</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-left">
                                                    Are you sure to download Formulir Pemberian Vaksinasi COVID-19 {{$pendaftar['nama_lengkap']}} ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <form method="GET" action="{{ route('pendaftaran.formulir_pendaftaran', ['event_id', $event_id, 'pendaftaran_id' => $pendaftar['id']]) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">Download</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </span>

                                {{-- Tombol Berhasil Datang dan Berhasil Vaksin --}}
                                @if($pendaftar->status_kedatangan == 0)
                                    <span>
                                        <button type="button" data-toggle="modal" data-target="#berhasil-datang-{{$pendaftar->id}}" class="btn btn-success m-1">
                                            Berhasil Datang
                                        </button>

                                        {{-- Berhasil Datang Modal --}}
                                        <div class="modal fade" id="berhasil-datang-{{$pendaftar->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Telah Datang</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-left">
                                                        Anda yakin peserta {{$pendaftar->nama_lengkap}} telah datang ke lokasi vaksinasi?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <form method="POST" action="{{ route('pendaftaran.berhasil_datang', ['event_id' => $event_id, 'pendaftaran_id' => $pendaftar->id]) }}">
                                                            @method('put')
                                                            @csrf
                                                            <button type="submit" class="btn btn-success">Yes</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </span>
                                @elseif($pendaftar->status_kedatangan == 1 && $pendaftar->status_keberhasilan_vaksinasi == 0)
                                    <span>
                                        <button type="button" data-toggle="modal" data-target="#berhasil-vaksin-{{$pendaftar->id}}" class="btn btn-success m-1">
                                            Berhasil Vaksin
                                        </button>

                                        {{-- Berhasil Vaksin Modal --}}
                                        <div class="modal fade" id="berhasil-vaksin-{{$pendaftar->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Telah Berhasil Vaksin</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-left">
                                                        Anda yakin peserta {{$pendaftar->nama_lengkap}} telah berhasil melakukan vaksinasi?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <form method="POST" action="{{ route('pendaftaran.berhasil_vaksin', ['event_id' => $event_id, 'pendaftaran_id' => $pendaftar->id]) }}">
                                                            @method('put')
                                                            @csrf
                                                            <button type="submit" class="btn btn-success">Yes</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
      
@endsection