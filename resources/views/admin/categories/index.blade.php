@extends('admin.layouts.app', [
    'pageName' => 'Categories',
])
@section('content')
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Categories List</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
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
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)                                
                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>
                                    <span class="badge badge-{{ $category->status->style() }}">{{ $category->status->label() }}</span>
                                    </td>
                                    <td>
                                        @if($category->photo)
                                            <img src="{{ asset('storage/'.$category->photo->path) }}" 
                                                alt="Category Image" width="60" height="60" class="img-thumbnail">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                        <a href="#"
                                            data-url="{{ route('admin.categories.destroy', $category->id) }}"
                                            data-id="{{$category->id}}"
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
                        {{$categories->links()}}
                </div>
            </div>
        </div>
@endsection


@push('scripts')
    @include('admin.layouts.partials._deleteAlert')
@endpush