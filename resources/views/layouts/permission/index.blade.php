@extends('layouts.home')

@section('content')
    <h2 class="text-dark">Permissions</h2>

    <div id="app" class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">Permissions Datatable</h6>
                </div>
                @can('Add')
                <div class="col text-right">
                    <a href="{{ route('permission.form') }}" role="button" class="btn bg-gradient-primary text-white">Add New Permission</a>
                </div>
                @endcan
            </div>
        </div>
        @can('Read')
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead align="center">
                        <tr>
                            <th>No.</th>
                            <th>Permission Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        @foreach($permissions as $permission)
                        <tr>
                            <td width="50">{{$loop->iteration}}</td>
                            <td>{{$permission->name}}</td>
                            <td width="200">
                                @can('Edit')
                                <span>
                                    <a href="{{ route('permission.form', $permission->id) }}" role="button" class="btn btn-warning">
                                        <i class="fas fa-edit text-light"></i>
                                    </a>
                                </span>
                                @endcan
                                @can('Delete')
                                <span>
                                    <button type="button" data-toggle="modal" data-target="#delete-{{$permission->id}}" class="btn btn-danger">
                                        <i class="fas fa-trash text-light"></i>
                                    </button>

                                    {{-- Delete Modal --}}
                                    <div class="modal fade" id="delete-{{$permission->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-left">
                                                    Are you sure to delete {{$permission->name}} ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <form method="POST" action="{{ route('permission.delete', $permission->id) }}">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </span>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endcan
    </div>
      
@endsection