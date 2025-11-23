@extends('admin.layouts.app', [
    'pageName' => 'Items',
])

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Items List</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.items.create') }}" class="btn btn-primary btn-sm">
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
                            <th>Item Code</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Min. Stock</th>
                            <th>Quantity</th>
                            <th>Shown in Store</th>
                            <th>Status</th>
                            <th >Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->item_code}}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->category->name}}</td>
                                <td>{{ $item->unit->name}}</td>
                                <td>{{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->minimum_stock }}</td>
                                <td>{{ ($item->warehouses->sum('pivot.quantity') > 0)? $item->warehouses->sum('pivot.quantity'): 0 }}</td>
                                <td>
                                    @if($item->is_shown_in_store)
                                        <span class="badge badge-success">Yes</span>
                                    @else
                                        <span class="badge badge-secondary">No</span>
                                    @endif
                                </td>
                                <td>  
                                    <span class="badge badge-{{ $item->status->style() }}">{{ $item->status->label() }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.items.edit', $item->id) }}" 
                                        class="btn btn-success btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.items.show', $item->id) }}" 
                                        class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#"
                                        data-url="{{ route('admin.items.destroy', $item->id) }}"
                                        data-id="{{ $item->id }}"
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
                {{ $items->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('admin.layouts.partials._deleteAlert') 
@endpush