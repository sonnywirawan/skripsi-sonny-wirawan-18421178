@extends('layouts.home')

@section('content')

@if(isset($id))
    <h2 class="text-dark">Edit Event</h2>
    <form type="submit" method="POST" action="{{ route('event.edit', $id) }}">
    {{ method_field('PUT') }}
@else
    <h2 class="text-dark">Create Event</h2>
    <form type="submit" method="POST" action="{{ route('event.store') }}">
@endif
@csrf
    <div class="row mb-2">
        <div class="col text-right">
            <button class="btn bg-gradient-primary text-white">{{ isset($id) ? 'Edit Data' : 'Save Data' }}</button>
        </div>
    </div>

    <div class="card border-left-dark shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">Data Event</h6>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="name">Nama Event</label>
                <textarea type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Event" required>{{ isset($data) ? $data->name : '' }}</textarea>
            </div>

            <div class="form-group">
                <label for="registration_start_date">Tanggal Mulai Pendaftaran</label>
                <input type="text" class="form-control" id="registration_start_date" name="registration_start_date" placeholder="Masukkan Tanggal Mulai Pendaftaran" value="{{ isset($data) ? Carbon\Carbon::parse($data->registration_start_date)->format('d-m-Y H:i') : '' }}" required>
            </div>
            <div class="form-group">
                <label for="registration_end_date">Tanggal Selesai Pendaftaran</label>
                <input type="text" class="form-control" id="registration_end_date" name="registration_end_date" placeholder="Masukkan Tanggal Selesai Pendaftaran" value="{{ isset($data) ? Carbon\Carbon::parse($data->registration_end_date)->format('d-m-Y H:i') : '' }}" required>
            </div>

            <div class="form-group">
                <label for="start_date">Tanggal Mulai Event</label>
                <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Masukkan Tanggal Mulai Event" value="{{ isset($data) ? Carbon\Carbon::parse($data->start_date)->format('d-m-Y H:i') : '' }}" required>
            </div>
            <div class="form-group">
                <label for="end_date">Tanggal Selesai Event</label>
                <input type="text" class="form-control" id="end_date" name="end_date" placeholder="Masukkan Tanggal Selesai Event" value="{{ isset($data) ? Carbon\Carbon::parse($data->end_date)->format('d-m-Y H:i') : '' }}" required>
            </div>

            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <textarea type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Masukkan Lokasi" required>{{ isset($data) ? $data->lokasi : '' }}</textarea>
            </div>

            <div class="form-group">
                <label for="limit">Limit</label>
                <input type="number" class="form-control" id="limit" name="limit" placeholder="Masukkan Limit" value="{{ isset($data) ? $data->limit : '' }}" required>
            </div>
        </div>
    </div>
</form>

@endsection

@push('js')
    <script>
        $(function() {
            $('#registration_start_date').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                singleDatePicker: true,
                showDropdowns: true,
                // startDate: moment().startOf('hour'),
                minYear: parseInt(moment().format('YYYY')),
                maxYear: parseInt(moment().format('YYYY')) + 10,
                locale: {
                    format: 'DD-MM-YYYY HH:mm'
                }
            });
        });
        $(function() {
            $('#registration_end_date').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                singleDatePicker: true,
                showDropdowns: true,
                // startDate: moment().startOf('hour'),
                minYear: parseInt(moment().format('YYYY')),
                maxYear: parseInt(moment().format('YYYY')) + 10,
                locale: {
                    format: 'DD-MM-YYYY HH:mm'
                }
            });
        });
        $(function() {
            $('#start_date').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                singleDatePicker: true,
                showDropdowns: true,
                // startDate: moment().startOf('hour'),
                minYear: parseInt(moment().format('YYYY')),
                maxYear: parseInt(moment().format('YYYY')) + 10,
                locale: {
                    format: 'DD-MM-YYYY HH:mm'
                }
            });
        });

        $(function() {
            $('#end_date').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                singleDatePicker: true,
                showDropdowns: true,
                // startDate: moment().startOf('hour'),
                minYear: parseInt(moment().format('YYYY')),
                maxYear: parseInt(moment().format('YYYY')) + 10,
                locale: {
                    format: 'DD-MM-YYYY HH:mm'
                }
            });
        });
    </script>
@endpush