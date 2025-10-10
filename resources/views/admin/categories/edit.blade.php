@extends('admin.layouts.app', [
    'pageName' => 'Categories',
])

@section('content')
    <div class="col-sm-12">
        <div class="card shadow-sm rounded-3">
            <div class="card-header bg-success text-white">
                <h3 class="card-title">Edit Category</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" 
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Enter category name" name="name" value="{{ old('name', $category->name) }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        @foreach ($categoryStatuses as $value => $label)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="{{ $value }}"
                                    @checked(old('status', $category->status->label()) == $label)>
                                <label class="form-check-label">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label for="image">Category Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"
                            id="image">
                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        @if ($category->photo)
                            <div class="mt-2">
                                <p>Current Image:</p>
                                <img src="{{ asset('storage/' . $category->photo->path) }}" alt="Category Image"
                                    width="100" height="100" class="img-thumbnail">
                            </div>
                        @endif
                    </div>
                                        <!-- زرار السبمت هنا -->
                                        <div class="form-group mt-3">
                                            <button type="submit" class="btn btn-primary">
                                                Update
                                            </button>
                                        </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{-- <x-form-submit text="Update"></x-form-submit> --}}
            </div>
        </div>
        <!-- /.card -->
    </div>
@endsection
