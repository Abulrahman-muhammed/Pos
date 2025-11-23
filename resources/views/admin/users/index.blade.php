@extends('admin.layouts.app', [
    'pageName' => 'Users',
])
@section('content')
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users List</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Create
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                        @include('admin.layouts.partials._flash')
                    
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Username</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)                                
                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{$user->username}}</td>
                                    <td>
                                    <span class="badge badge-{{ $user->status->style() }}">{{ $user->status->label() }}</span>
                                    </td>
                                    <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if( auth()->user()->id == 1 || auth()->user()->id != $user->id)
                                        <a href="#"
                                            data-url="{{ route('admin.users.destroy', $user->id) }}"
                                            data-id="{{$user->id}}"
                                            class="btn btn-danger btn-sm delete-button">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                        {{$users->links()}}
                </div>
            </div>
        </div>
@endsection


@push('scripts')
    @include('admin.layouts.partials._deleteAlert')
@endpush