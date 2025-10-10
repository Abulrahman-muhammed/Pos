@extends('admin.layouts.app', [
    'pageName' => 'Units',
])

@section('content')
    <div class="col-sm-12">
        <div class="card shadow-sm rounded-3">
            <div class="card-header bg-success text-white">
                <h3 class="card-title">Edit Unit</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="POST" action="{{ route('admin.units.update', $unit->id) }}" >
                    @method('PUT')
                    @csrf

                    <div class="form-group">
                        <label for="name">Unit Name</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Enter Unit name" name="name" value="{{ old('name', $unit->name) }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        @foreach ($unitStatus as $value => $label)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="{{ $value }}"
                                    @checked(old('status', $unit->status->label()) == $label)>
                                <label class="form-check-label">{{ $label }}</label>
                            </div>
                        @endforeach
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
