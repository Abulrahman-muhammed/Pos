@extends('admin.layouts.app', [
    'pageName' => 'units',
])
@section('content')
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">units List</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.units.create') }}" class="btn btn-primary btn-sm">
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
                                <th>Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($units as $unit)                                
                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{$unit->name}}</td>
                                    <td>
                                    <span class="badge badge-{{ $unit->status->style() }}">{{ $unit->status->label() }}</span>
                                    </td>

                                    <td>
                                    <a href="{{ route('admin.units.edit', $unit->id) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                        <a href="#"
                                            data-url="{{ route('admin.units.destroy', $unit->id) }}"
                                            data-id="{{$unit->id}}"
                                            class="btn btn-danger btn-sm delete-button">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                        {{$units->links()}}
                </div>
            </div>
        </div>
@endsection

@push('scripts')
    @include('admin.layouts.partials._deleteAlert')
@endpush
