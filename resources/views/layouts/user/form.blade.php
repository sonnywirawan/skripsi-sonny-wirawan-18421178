@extends('layouts.home')

@section('content')

@if(isset($id))
    <h2 class="text-dark">Edit User</h2>
    <form type="submit" method="POST" action="{{ route('user.edit', $id) }}">
    {{ method_field('PUT') }}
@else
    <h2 class="text-dark">Create User</h2>
    <form type="submit" method="POST" action="{{ route('user.store') }}">
@endif
@csrf
    <div class="row mb-2">
        <div class="col text-right">
            <button class="btn bg-gradient-primary text-white">{{ isset($id) ? 'Edit Data' : 'Save Data' }}</button>
        </div>
    </div>

    {{-- Data User --}}
    <div class="card border-left-success shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Lengkap" value="{{ isset($data) ? $data->name : '' }}">
            </div>
            <div class="form-group">
                <label for="username">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" value="{{ isset($data) ? $data->email : '' }}">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control border-right-0" id="password" name="password" placeholder="Masukkan Password" value="">
                    <span class="input-group-append transparent rounded-right" style="border: 1px solid lightgrey;">
                        <i id="icon_password" class="fas fa-eye mt-2 mr-3" @click="clickIcon"></i>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <div class="input-group">
                    <input type="password" class="form-control border-right-0" id="password_confirmation" name="password_confirmation" placeholder="Masukkan Konfirmasi Password" value="">
                    <span class="input-group-append transparent rounded-right" style="border: 1px solid lightgrey;">
                        <i id="icon_confirm_password" class="fas fa-eye mt-2 mr-3" @click="clickIconConfirm"></i>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label for="roles">Role</label>
                <select id="roles" name="roles" class="form-control">
                  <option selected disabled hidden>Select Role</option>
                  @foreach($roles as $role)
                    <option {{isset($data) && $data->roles[0]->id == $role->id ? "selected" : ''}} value="{{ $role->id }}">{{ $role->name }}</option>
                  @endforeach
                </select>
            </div>
        </div>
    </div>
</form>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12">
        import Vue from 'vue'
    </script>
    <script>
        var password = new Vue({
            el: '#icon_password',
            data: {
                obscureText: true,
            },
            methods: {
                clickIcon() {
                    this.obscureText = !this.obscureText;
                    if(this.obscureText) {
                        $('#icon_password').attr('class', 'fas fa-eye mt-2 mr-3');
                        $('#password').attr('type', 'password');
                    } else {
                        $('#icon_password').attr('class', 'fas fa-eye-slash mt-2 mr-3');
                        $('#password').attr('type', 'text');
                    }
                }   
            },
        })
        var confirmPassword = new Vue({
            el: '#icon_confirm_password',
            data: {
                obscureText: true,
            },
            methods: {
                clickIconConfirm() {
                    this.obscureText = !this.obscureText;
                    if(this.obscureText) {
                        $('#icon_confirm_password').attr('class', 'fas fa-eye mt-2 mr-3');
                        $('#password_confirmation').attr('type', 'password');
                    } else {
                        $('#icon_confirm_password').attr('class', 'fas fa-eye-slash mt-2 mr-3');
                        $('#password_confirmation').attr('type', 'text');
                    }
                }
            },
        })
    </script>
@endpush