@extends('layouts.home')

@section('content')
    <h2 class="text-dark">Events</h2>

    <div id="app" class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">Events Datatable</h6>
                </div>
                @role('Admin')
                <div class="col text-right">
                    <a href="{{ route('event.form') }}" role="button" class="btn bg-gradient-primary text-white">Add New Event</a>
                </div>
                @endrole
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead align="center">
                        <tr>
                            <th>No.</th>
                            <th>Nama Event</th>
                            <th>Waktu Pendaftaran</th>
                            <th>Waktu Pelaksanaan</th>
                            <th>Lokasi</th>
                            <th>Jumlah peserta OTC</th>
                            <th>Jumlah peserta Online / Limit</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        @foreach($events as $event)
                        <tr>
                            <td width="50">{{$loop->iteration}}</td>
                            <td>{{$event->name}}</td>
                            <td>{{\Carbon\Carbon::parse($event->registration_start_date)->isoFormat('D MMMM Y')}} s.d {{\Carbon\Carbon::parse($event->registration_end_date)->isoFormat('D MMMM Y')}}</td>
                            <td>{{\Carbon\Carbon::parse($event->start_date)->isoFormat('D MMMM Y')}} s.d {{\Carbon\Carbon::parse($event->end_date)->isoFormat('D MMMM Y')}}</td>
                            <td>{{$event->lokasi}}</td>
                            <td>{{$event->pendaftaran->where('jenis_pendaftaran', 'OTC')->count()}}</td>
                            <td>{{$event->pendaftaran->where('jenis_pendaftaran', 'Online')->count() . " / " . $event->limit}}</td>
                            <td width="200">
                                @role('Admin')
                                    <span>
                                        <a href="{{ route('event.form', $event->id) }}" role="button" class="btn btn-warning">
                                            <i class="fas fa-edit text-light"></i>
                                        </a>
                                    </span>
                                    <span>
                                        <button type="button" data-toggle="modal" data-target="#delete-{{$event->id}}" class="btn btn-danger">
                                            <i class="fas fa-trash text-light"></i>
                                        </button>

                                        {{-- Delete Modal --}}
                                        <div class="modal fade" id="delete-{{$event->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-left">
                                                        Are you sure to delete {{$event->name}} ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <form method="POST" action="{{ route('event.delete', $event->id) }}">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </span>
                                    <span>
                                        <a href="{{ route('pendaftaran.index', $event->id) }}" role="button" class="btn btn-info">
                                            <i class="fas fa-users text-light"></i>
                                        </a>
                                    </span>
                                    <span>
                                        <a target="_blank" href="{{ route('event.cetak-daftar-hadir', $event->id) }}" role="button" class="btn btn-success">
                                            <i class="fas fa-file-excel text-light"></i>
                                        </a>
                                    </span>
                                @else
                                    {{-- For Pendaftar --}}
                                    @if(\Carbon\Carbon::now() >= \Carbon\Carbon::parse($event->registration_start_date) && \Carbon\Carbon::now() <= \Carbon\Carbon::parse($event->registration_end_date))
                                    <span>
                                        <a href="{{ route('pendaftaran.form', $event->id) }}" role="button" class="btn btn-success m-2">
                                            <i class="fas fa-user-plus text-light mr-2"></i>Daftar
                                        </a>
                                    </span>
                                    @endif
                                @endrole
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
      
@endsection