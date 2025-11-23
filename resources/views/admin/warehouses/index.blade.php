@extends('admin.layouts.app', [
    'pageName' => 'Warehouses',
])

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Warehouses List</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.warehouses.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Create
                    </a>
                </div>
            </div>

            <div class="card-body">

                @include('admin.layouts.partials._flash')

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Items Count</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($warehouses as $warehouse)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $warehouse->name }}</td>

                                <td>{{ Str::limit($warehouse->description, 30) }}</td>
                                <td>{{ $warehouse->items()->count() }}</td>
                                <td>
                                        <span class="badge badge-{{ $warehouse->status->style()}}">{{ $warehouse->status->label() }}</span>
                                </td>

                                <td>{{ $warehouse->created_at }}</td>

                                <td>
                                    <a href="{{ route('admin.warehouses.edit', $warehouse->id) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="#"
                                        data-url="{{ route('admin.warehouses.destroy', $warehouse->id) }}"
                                        data-id="{{ $warehouse->id }}"
                                        class="btn btn-danger btn-sm delete-button">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $warehouses->links() }}
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    @include('admin.layouts.partials._deleteAlert')
@endpush
