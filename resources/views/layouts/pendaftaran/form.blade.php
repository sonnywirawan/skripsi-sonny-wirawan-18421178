@extends('layouts.home')

@section('content')

@if(isset($id))
    <h2 class="text-dark">Edit Pendaftar</h2>
    <form type="submit" method="POST" action="{{ route('pendaftaran.edit', ['event_id' => $event_id, 'pendaftaran_id' => $id]) }}">
    {{ method_field('PUT') }}
@else
    @role('Admin')
        <h2 class="text-dark">Create Pendaftar</h2>
    @else
        <h2 class="text-dark">Daftar</h2>
    @endrole
    <form type="submit" method="POST" action="{{ route('pendaftaran.store', ['event_id' => $event_id]) }}">
@endif
@csrf
    <div class="row mb-2">
        <div class="col text-right">
            <button class="btn bg-gradient-primary text-white">{{ isset($id) ? 'Edit Data' : 'Save Data' }}</button>
        </div>
    </div>

    {{-- Data Pendaftar --}}
    <div class="card border-left-primary shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pendaftar</h6>
        </div>
        <div class="card-body">
            {{-- NIK --}}
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" maxlength="16" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK" value="{{ isset($data) ? $data->nik : '' }}" required>
            </div>
            {{-- Nama Lengkap --}}
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" value="{{ isset($data) ? $data->nama_lengkap : '' }}" required>
            </div>
            {{-- No. HP --}}
            <div class="form-group">
                <label for="no_hp">No. HP</label>
                <input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan No HP" value="{{ isset($data) ? $data->no_hp : '' }}" required>
            </div>
            {{-- JK --}}
            <label>Jenis Kelamin</label>
            <div class="row">
                <div class="col-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jk" value="Laki-Laki"
                        @php
                            if(isset($data)) {
                                if($data->jk == 'Laki-Laki') {
                                    echo 'checked';
                                }
                            }
                        @endphp>
                        <label class="form-check-label">
                          Laki-Laki
                        </label>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jk" value="Perempuan"
                        @php
                            if(isset($data)) {
                                if($data->jk == 'Perempuan') {
                                    echo 'checked';
                                }
                            }
                        @endphp>
                        <label class="form-check-label">
                          Perempuan
                        </label>
                    </div>
                </div>
            </div>
            {{-- Tempat Lahir --}}
            <div class="form-group mt-2">
                <label for="tempat_lahir">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan Tempat Lahir" value="{{ isset($data) ? $data->tempat_lahir : '' }}" required>
            </div>
            {{-- Tgl Lahir --}}
            <div class="form-group">
                @php
                    if(isset($data)) {
                        $tgl_lahir = Carbon\Carbon::parse($data->tgl_lahir)->format('m/d/Y');
                    }
                @endphp
                <label for="tgl_lahir">Tgl Lahir</label>
                <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" placeholder="Masukkan Tgl Lahir" value="{{ isset($data) ? $tgl_lahir : '' }}" required>
            </div>
            {{-- Alamat --}}
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan Alamat" required>{{ isset($data) ? $data->alamat : '' }}</textarea>
            </div>
            {{-- Status Kedatangan --}}
            <div class="form-group">
                <label for="status_kedatangan">Status Kedatangan</label>
                <input id="status_kedatangan" name="status_kedatangan" type="checkbox" checked data-toggle="toggle">
            </div>
        </div>
    </div>
</form>


@push('js')
    <script>
        $(function() {
            $('input[name="tgl_lahir"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format('YYYY'),10),
                autoApply: true,
            }, function(start, end, label) {
                // var years = moment().diff(start, 'years');
                // alert("You are " + years + " years old!");
            });
        });
    </script>
@endpush
@endsection