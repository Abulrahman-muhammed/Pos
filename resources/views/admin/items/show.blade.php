@extends('admin.layouts.app', [
    'pageName' => 'Items',
])

@section('content')
    <div class="col-sm-12">
        <div class="card shadow-sm rounded-3">
            <div class="card-header bg-info text-white">
                <h3 class="card-title">Show Item</h3>
            </div>

            <div class="card-body">

                <div class="form-group mb-3">
                    <label class="fw-bold">Item Name</label>
                    <input class="form-control" value="{{ $item->name }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label class="fw-bold">Item Code</label>
                    <input class="form-control" value="{{ $item->item_code }}" readonly>
                </div>

                <div class="form-group mb-4">
                    <label class="fw-bold">Description</label>
                    <textarea class="form-control" rows="3" readonly>{{ $item->description }}</textarea>
                </div>

                <div class="row">
                    <div class="form-group col-md-4 mb-3">
                        <label class="fw-bold">Price</label>
                        <input class="form-control" value="{{ $item->price }}" readonly>
                    </div>

                    <div class="form-group col-md-4 mb-3">
                        <label class="fw-bold">Quantity</label>
                        <input class="form-control" value="{{ $item->quantity }}" readonly>
                    </div>

                    <div class="form-group col-md-4 mb-3">
                        <label class="fw-bold">Minimum Stock</label>
                        <input class="form-control" value="{{ $item->minimum_stock }}" readonly>
                    </div>
                </div>


                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label class="fw-bold">Category</label>
                        <input class="form-control" value="{{ $item->category?->name }}" readonly>
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        <label class="fw-bold">Unit</label>
                        <input class="form-control" value="{{ $item->unit?->name }}" readonly>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="fw-bold">Status</label><br>
                        <span class="badge bg-{{ $item->status->style() }} px-3 py-2">{{ $item->status->label() }}</span>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold">Show in Store</label><br>
                        <span class="badge {{ $item->is_shown_in_store ? 'bg-primary' : 'bg-secondary' }} px-3 py-2">
                            {{ $item->is_shown_in_store ? 'Yes' : 'No' }}
                        </span>
                    </div>
                </div>

                {{-- Photos Section --}}
                <table class="table table-bordered shadow-sm" style="border-radius: 12px; overflow: hidden;">
                    <thead class="table-info">
                        <tr>
                            <th class="text-center">Main Photo</th>
                            <th class="text-center">Gallery</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            {{-- Main Photo --}}
                            <td class="text-center align-middle">
                                @if ($item->mainPhoto)
                                    <a href="{{ asset('storage/' . $item->mainPhoto->path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $item->mainPhoto->path) }}"
                                            class="img-thumbnail shadow-sm" style="max-width: 180px; border-radius: 12px;">
                                    </a>
                                @else
                                    <span class="text-muted">No Main Photo</span>
                                @endif
                            </td>

                            {{-- Gallery --}}
                            <td>
                                <div
                                    style="display: flex; gap: 10px; flex-wrap: wrap; max-height: 200px; overflow-y: auto; padding: 5px;">
                                    @if ($item->gallery && $item->gallery->count() > 0)
                                        @foreach ($item->gallery as $photo)
                                            <a href="{{ asset('storage/' . $photo->path) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $photo->path) }}"
                                                    class="img-thumbnail shadow-sm"
                                                    style="max-width: 100px; border-radius: 10px;">
                                            </a>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No Gallery Photos</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>



                <div class="card-footer text-end">
                    <a href="{{ route('admin.items.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
