@extends('admin.layouts.app', [
    'pageName' => 'Create Warehouse',
])

@section('content')
<div class="col-sm-12">
    <div class="card">

        <div class="card-header">
            <h3 class="card-title">Create Warehouse</h3>
        </div>

        <div class="card-body">
            @include('admin.layouts.partials._flash')

            <form action="{{ route('admin.warehouses.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" >

                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description"
                              class="form-control @error('description') is-invalid @enderror"
                              rows="4">{{ old('description') }}</textarea>

                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status"
                            class="form-control @error('status') is-invalid @enderror">
                            @foreach ($warehouseSatatusEnum as $value => $label)
                                <option value="{{ $value }}" {{ old('value') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                    </select>

                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
            </form>

        </div>
    </div>
</div>
@endsection
