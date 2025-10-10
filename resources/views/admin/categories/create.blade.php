@extends('admin.layouts.app', [
    'pageName' => 'Categories',
])

@section('content')
        <div class="col-sm-12">
            <div class="card shadow-sm rounded-3 " >
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Categories Create</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.categories.store') }}" id="main-form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Category Name</label>
                            <input class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   placeholder="Enter category name"
                                   name="name"
                                   value="{{ old('name') }}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    
                        <div class="form-group">
                            <label>Status</label>
                            @foreach($categoryStatuses as $value => $label)
                                <div class="form-check ">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="status"
                                           value="{{ $value }}"
                                           @if($loop->first) checked @endif
                                           @checked(old('status') == $value)>
                                    <label class="form-check-label">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                    
                        <div class="form-group">
                            <label for="image">Category Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror " name="image" id="image">
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    {{--  photo preview --}}
                    <div id="main-preview" class="mt-3"></div>
                    </form>
                    
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <x-form-submit text="Create"></x-form-submit>
                </div>
            </div>
            <!-- /.card -->
        </div>
@endsection



@push('scripts')
   <script>
        $(document).ready(function() {
            $('#image').on('change', function() {
                let files = this.files;
                $('#main-preview').html(''); 
                if (files) {
                    $.each(files, function(index, file) {
                        let reader = new FileReader();
                        reader.onload = function(e) {
                            let img = $('<img>').attr('src', e.target.result).addClass('img-thumbnail m-2').css({'max-width': '150px', 'max-height': '150px'});
                            $('#main-preview').append(img);
                        }
                        reader.readAsDataURL(file);
                    });
                }
            });
        });
    </script>
    @endpush 