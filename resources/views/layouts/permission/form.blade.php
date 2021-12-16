@extends('layouts.home')

@section('content')

@if(isset($id))
    <h2 class="text-dark">Edit Permission</h2>
    <form type="submit" method="POST" action="{{ route('permission.edit', $id) }}">
    {{ method_field('PUT') }}
@else
    <h2 class="text-dark">Create Permission</h2>
    <form type="submit" method="POST" action="{{ route('permission.store') }}">
@endif
@csrf
    <div class="row mb-2">
        <div class="col text-right">
            <button class="btn bg-gradient-primary text-white">{{ isset($id) ? 'Edit Data' : 'Save Data' }}</button>
        </div>
    </div>

    <div class="card border-left-primary shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Permission</h6>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="name">Nama Permission</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Permission" value="{{ isset($data) ? $data->name : '' }}">
            </div>
        </div>
    </div>
</form>

@endsection