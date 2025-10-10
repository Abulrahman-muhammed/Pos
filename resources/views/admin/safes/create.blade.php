@extends('admin.layouts.app', [
    'pageName' => 'Safes',
])

@section('content')
    <div class="col-sm-12">
        <div class="card shadow-sm rounded-3">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Create Safe</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="POST" action="{{ route('admin.safes.store') }}" id="main-form">
                    @csrf

                    <!-- Name -->
                    <div class="form-group">
                        <label for="name">Safe Name</label>
                        <input class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               placeholder="Enter safe name"
                               name="name"
                               value="{{ old('name') }}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div class="form-group">
                        <label>Type</label>
                        @foreach($safetypes as $value => $label)
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="type"
                                       value="{{ $value }}"
                                       @if($loop->first) checked @endif
                                       @checked(old('type') == $value)>
                                <label class="form-check-label">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Balance -->
                    <div class="form-group">
                        <label for="balance">Balance</label>
                        <input class="form-control @error('balance') is-invalid @enderror"
                               id="balance"
                               type="number"
                               step="0.01"
                               placeholder="Enter safe balance"
                               name="balance"
                               value="{{ old('balance', 0) }}">
                        @error('balance')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label>Status</label>
                        @foreach($safeStatus as $value => $label)
                            <div class="form-check">
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

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description"
                                  placeholder="Enter safe description"
                                  name="description">{{ old('description') }}</textarea>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
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
