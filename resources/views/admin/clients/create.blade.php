@extends('admin.layouts.app', [
    'pageName' => 'Clients',
])

@section('content')
    <div class="col-sm-12">
        <div class="card shadow-sm rounded-3">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Create Client</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="POST" action="{{ route('admin.clients.store') }}" id="main-form">
                    @csrf

                    <!-- Name -->
                    <div class="form-group">
                        <label for="name">Client Name</label>
                        <input class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               placeholder="Enter client name"
                               name="name"
                               value="{{ old('name') }}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror"
                               id="email"
                               type="email"
                               placeholder="Enter client email"
                               name="email"
                               value="{{ old('email') }}">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input class="form-control @error('phone') is-invalid @enderror"
                               id="phone"
                               placeholder="Enter client phone"
                               name="phone"
                               value="{{ old('phone') }}">
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror"
                                  id="address"
                                  placeholder="Enter client address"
                                  name="address">{{ old('address') }}</textarea>
                        @error('address')
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
                               placeholder="Enter client balance"
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
                        @foreach($clientStatus as $value => $label)
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
