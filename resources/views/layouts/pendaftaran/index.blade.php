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
                            <th>NIP</th>
                            <th>Nama Lengkap</th>
                            <th>No. HP</th>
                            <th>Tempat & Tgl Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Pekerjaan</th>
                            <th>Pangkat/Golongan</th>
                            <th>Jabatan</th>
                            <th>Instansi</th>
                            <th>NPWP</th>
                            <th>Nama Bank</th>
                            <th>Nomor Rekening</th>
                            <th>Biaya Perjalanan PP</th>
                            <th>Status Pendaftaran Ulang</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        @foreach($pendaftaran as $pendaftar)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$pendaftar->nip}}</td>
                            <td>{{$pendaftar->nama_lengkap}}</td>
                            <td>{{$pendaftar->no_hp}}</td>
                            <td>{{$pendaftar->tempat_lahir}}, {{$pendaftar->tgl_lahir}}</td>
                            <td>{{$pendaftar->jk}}</td>
                            <td>{{$pendaftar->pekerjaan->nama}}</td>
                            <td>{{$pendaftar->pangkat}}</td>
                            <td>{{$pendaftar->jabatan}}</td>
                            <td>{{$pendaftar->instansi}} {{$pendaftar->kabupaten->nama_kabupaten}}</td>
                            <td>{{$pendaftar->npwp}}</td>
                            <td>{{$pendaftar->nama_bank}}</td>
                            <td>{{$pendaftar->no_rekening}}</td>
                            <td>Rp {{number_format($pendaftar->biaya_perjalanan, 0, '.')}}</td>
                            <td>
                                @if($pendaftar->status_pendaftaran_ulang == 0)
                                    <i class="fas fa-times fa-2x text-danger">
                                @else
                                    <i class="fas fa-check fa-2x text-success">
                                @endif
                            </td>
                            <td width="100">
                                @if($pendaftar->status_pendaftaran_ulang == 0)
                                <span>
                                    <button type="button" data-toggle="modal" data-target="#daftar-ulang-{{$pendaftar->id}}" class="btn btn-success m-1">
                                        Daftar Ulang
                                    </button>

                                    {{-- Daftar Ulang Modal --}}
                                    <div class="modal fade" id="daftar-ulang-{{$pendaftar->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Telah Mendaftar Ulang</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-left">
                                                    Anda yakin peserta {{$pendaftar->nama_lengkap}} telah melakukan pendaftaran ulang?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <form method="POST" action="{{ route('pendaftaran.daftar_ulang', ['event_id' => $event_id, 'pendaftaran_id' => $pendaftar->id]) }}">
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
                                <span>
                                    <a href="{{ route('pendaftaran.form', ['event_id' => $event_id, 'pendaftaran_id' => $pendaftar->id]) }}" role="button" class="btn btn-warning">
                                        <i class="fas fa-edit text-light"></i>
                                    </a>
                                </span>
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
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
      
@endsection