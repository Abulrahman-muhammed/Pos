@extends('admin.layouts.app', [
    'pageName' => 'Safes',
])

@section('content')
    <div class="col-sm-12">
        <div class="card shadow-sm rounded-3">
            <div class="card-header bg-success text-white">
                <h3 class="card-title">Edit Safe</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="POST" action="{{ route('admin.safes.update', $safe->id) }}" id="main-form">
                    @csrf
                    @method('PUT')

                    <!-- Safe Name -->
                    <div class="form-group">
                        <label for="name">Safe Name</label>
                        <input class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               placeholder="Enter safe name"
                               name="name"
                               value="{{ old('name', $safe->name) }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
                               value="{{ old('balance', $safe->balance) }}">
                        @error('balance')
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
                                       @checked(old('type', $safe->type->value) == $value)>
                                <label class="form-check-label">{{ ucfirst($label) }}</label>
                            </div>
                        @endforeach
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
                                       @checked(old('status', $safe->status->value) == $value)>
                                <label class="form-check-label">{{ ucfirst($label) }}</label>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <x-form-submit text="Update"></x-form-submit>
            </div>
        </div>
        <!-- /.card -->
    </div>
@endsection
