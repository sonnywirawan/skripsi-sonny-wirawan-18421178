@extends('layouts.home')

@section('content')

@if(isset($id))
    <h2 class="text-dark">Edit Role</h2>
    <form type="submit" method="POST" action="{{ route('role.edit', $id) }}">
    {{ method_field('PUT') }}
@else
    <h2 class="text-dark">Create Role</h2>
    <form type="submit" method="POST" action="{{ route('role.store') }}">
@endif
@csrf
    <div class="row mb-2">
        <div class="col text-right">
            <button class="btn bg-gradient-primary text-white">{{ isset($id) ? 'Edit Data' : 'Save Data' }}</button>
        </div>
    </div>

    <div class="card border-left-primary shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Role</h6>
        </div>
        <div class="card-body">
            {{-- Nama Role --}}
            <div class="form-group">
                <label for="name">Nama Role</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Role" value="{{ isset($data) ? $data->name : '' }}">
            </div>
            {{-- Permissions --}}
            <label>Select Permissions</label>
            <div class="row">
                @foreach($permissions as $key => $permission)
                    <div class="col-4">
                        <div class="card border-left-success shadow m-2 p-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $permission->id }}" name="permissions[]" id="permissions"
                                @php
                                if(isset($data)) {
                                    foreach($data->permissions as $data_perm) {
                                        if($data_perm->id == $permission->id) {
                                            echo 'checked';
                                        } else {
                                            echo '';
                                        }
                                    } 
                                }
                                @endphp
                                >
                                <label class="form-check-label" for="permissions[]">{{ $permission->name }}</label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</form>

@endsection