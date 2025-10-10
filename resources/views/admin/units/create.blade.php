@extends('admin.layouts.app', [
    'pageName' => 'Units',
])

@section('content')
        <div class="col-sm-12">
            <div class="card shadow-sm rounded-3 " >
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Units Create</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.units.store') }}" id="main-form" >
                        @csrf
                        <div class="form-group">
                            <label for="name">Unit Name</label>
                            <input class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   placeholder="Enter Units name"
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
                            @foreach($unitStatus as $value => $label)
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