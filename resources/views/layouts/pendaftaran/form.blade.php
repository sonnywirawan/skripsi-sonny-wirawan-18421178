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
            <div class="form-group">
                <label for="nip">NIP</label>
                <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP" value="{{ isset($data) ? $data->nip : '' }}" required>
            </div>
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" value="{{ isset($data) ? $data->nama_lengkap : '' }}" required>
            </div>
            <div class="form-group">
                <label for="no_hp">No. HP</label>
                <input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan No. HP" value="{{ isset($data) ? $data->no_hp : '' }}" required>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan Tempat Lahir" value="{{ isset($data) ? $data->tempat_lahir : '' }}" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="tgl_lahir">Tgl. Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" placeholder="Masukkan Tgl. Lahir" value="{{ isset($data) ? $data->tgl_lahir : '' }}" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="jk">Jenis Kelamin</label>
                <select class="form-control" name="jk" id="jk" required>
                    <option value="" selected disabled>Pilih Jenis Kelamin</option>
                    <option @if(isset($data)) @if($data->jk == "Laki-Laki") selected @endif @endif value="Laki-Laki">Laki-Laki</option>
                    <option @if(isset($data)) @if($data->jk == "Perempuan") selected @endif @endif value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="pekerjaan_id">Status / Pekerjaan</label>
                <select class="form-control" name="pekerjaan_id" id="pekerjaan_id" required>
                    <option value="" selected disabled>Pilih Status / Pekerjaan</option>
                    @foreach($pekerjaan_all as $pekerjaan)
                        <option value="{{$pekerjaan->id}}"
                            @if(isset($data))
                                @if($pekerjaan->id == $data->pekerjaan_id)
                                    selected
                                @endif
                            @endif
                            >{{$pekerjaan->nama}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="pangkat">Pangkat / Golongan</label>
                <input type="text" class="form-control" id="pangkat" name="pangkat" placeholder="Masukkan Pangkat / Golongan" value="{{ isset($data) ? $data->pangkat : '' }}" required>
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukkan Jabatan" value="{{ isset($data) ? $data->jabatan : '' }}" required>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="instansi">Instansi</label>
                        <input type="text" class="form-control" id="instansi" name="instansi" placeholder="Masukkan Instansi" value="{{ isset($data) ? $data->instansi : '' }}" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="kabupaten_id">Kabupaten / Kota</label>
                        <select class="form-control" name="kabupaten_id" id="kabupaten_id" required>
                            <option value="" selected disabled>Pilih Kabupaten / Kota</option>
                            @foreach($kabupaten_all as $kabupaten)
                                <option value="{{$kabupaten->id}}"
                                    @if(isset($data))
                                        @if($kabupaten->id == $data->kabupaten_id)
                                            selected
                                        @endif
                                    @endif
                                    >{{$kabupaten->nama_kabupaten}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="npwp">NPWP</label>
                <input type="text" class="form-control" id="npwp" name="npwp" placeholder="Masukkan NPWP" value="{{ isset($data) ? $data->npwp : '' }}" required>
            </div>
            <div class="form-group">
                <label for="nama_bank">Nama Bank</label>
                <select class="form-control" name="nama_bank" id="nama_bank" required>
                    <option value="" selected disabled>Pilih Bank</option>
                    <option @if(isset($data)) @if($data->nama_bank == "BCA") selected @endif @endif value="BCA">BCA</option>
                    <option @if(isset($data)) @if($data->nama_bank == "BNI") selected @endif @endif value="BNI">BNI</option>
                    <option @if(isset($data)) @if($data->nama_bank == "Bank Kalbar") selected @endif @endif value="Bank Kalbar">Bank Kalbar</option>
                    <option @if(isset($data)) @if($data->nama_bank == "Mandiri") selected @endif @endif value="Mandiri">Mandiri</option>
                    <option @if(isset($data)) @if($data->nama_bank == "BRI") selected @endif @endif value="BRI">BRI</option>
                </select>
            </div>
            <div class="form-group">
                <label for="no_rekening">Nomor Rekening</label>
                <input type="number" class="form-control" id="no_rekening" name="no_rekening" placeholder="Masukkan Nomor Rekening" value="{{ isset($data) ? $data->no_rekening : '' }}" required>
            </div>
            <div class="form-group">
                <label for="biaya_perjalanan">Biaya Perjalanan PP</label>
                <input oninput="digitGrouping(this.value)" type="text" class="form-control" id="biaya_perjalanan" name="biaya_perjalanan" placeholder="Masukkan Biaya Perjalanan" value="{{ isset($data) ? $data->biaya_perjalanan : '' }}" required>
            </div>
            @if(isset($data))
            <div class="form-group">
                <label for="status_pendaftaran_ulang">Status Pendaftaran Ulang</label>
                <select class="form-control" name="status_pendaftaran_ulang" id="status_pendaftaran_ulang" required>
                    <option value="" selected disabled>Pilih Status</option>
                    <option @if(isset($data)) @if($data->status_pendaftaran_ulang == 1) selected @endif @endif value="1">Sudah Mendaftar Ulang</option>
                    <option @if(isset($data)) @if($data->status_pendaftaran_ulang == 0) selected @endif @endif value="0">Belum Mendaftar Ulang</option>
                </select>
            </div>
            @endif
        </div>
    </div>
</form>


@push('js')
    <script>
        function digitGrouping( num ) {
            var str = num.match(/\d/g);
            if(str == null) {
                document.getElementById('biaya_perjalanan').value = "";
            } else {
                var str = str.join('').split('.');
                if (str[0].length >= 5) {
                    str[0] = str[0].replace(/(\d)(?=(\d{3})+$)/g, '$1,');
                }
                if (str[1] && str[1].length >= 5) {
                    str[1] = str[1].replace(/(\d{3})/g, '$1 ');
                }
                document.getElementById('biaya_perjalanan').value = str.join('.');
                return str.join('.');
            }
        }

        var id = {!! json_encode($id) !!}
        if(id != null) {
            digitGrouping(document.getElementById('biaya_perjalanan').value);
        }
    </script>
@endpush
@endsection