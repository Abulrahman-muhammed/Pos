@extends('admin.layouts.app', [
    'pageName' => 'Items',
])

@section('content')
    <div class="col-sm-12">
        <div class="card shadow-sm rounded-3">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Edit Item</h3>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.items.update', $item->id) }}" id="main-form"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Item Name --}}
                    <div class="form-group mb-3">
                        <label for="name" class="fw-bold">Item Name</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name', $item->name) }}">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Item Code --}}
                    <div class="form-group mb-3">
                        <label for="item_code" class="fw-bold">Item Code</label>
                        <input class="form-control @error('item_code') is-invalid @enderror" id="item_code" name="item_code"
                            value="{{ old('item_code', $item->item_code) }}">
                        @error('item_code')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group mb-3">
                        <label for="description" class="fw-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="3">{{ old('description', $item->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Price / Quantity / Minimum Stock --}}
                    <div class="row">
                        <div class="form-group  col-md-6 mb-3">
                            <label for="price" class="fw-bold">Price</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                id="price" name="price" value="{{ old('price', $item->price) }}">
                            @error('price')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>



                        <div class="form-group  col-md-6 mb-3">
                            <label for="minimum_stock" class="fw-bold">Minimum Stock</label>
                            <input type="number" step="0.01"
                                class="form-control @error('minimum_stock') is-invalid @enderror" id="minimum_stock"
                                name="minimum_stock" value="{{ old('minimum_stock', $item->minimum_stock) }}">
                            @error('minimum_stock')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Category & Unit --}}
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="category_id" class="fw-bold">Category</label>
                            <select name="category_id" class="form-control select2
                                @error('category_id') is-invalid @enderror">
                                <option value="" selected>-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $item->category_id) == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label for="unit_id" class="fw-bold">Unit</label>
                            <select name="unit_id" class="form-control select2 @error('unit_id') is-invalid @enderror">
                                <option value="" selected>-- Select Unit --</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}" @selected(old('unit_id', $item->unit_id) == $unit->id)>
                                        {{ $unit->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('unit_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="form-group mb-3">
                        <label class="fw-bold">Status</label>
                        <div>
                            @foreach ($itemStatus as $value => $label)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status"
                                        value="{{ $value }}" @checked(old('status', $item->status->label()) == $label)>
                                    <label class="form-check-label">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Show in Store --}}
                    <div class="form-group mb-3">
                        <label class="fw-bold">
                            <input type="hidden" name="is_shown_in_store" value="0">
                            <input type="checkbox" name="is_shown_in_store" value="1"
                                {{ old('is_shown_in_store', $item->is_shown_in_store) ? 'checked' : '' }}>
                            Show in Store
                        </label>
                    </div>

                    {{-- Main Photo --}}
                    <div class="form-group mb-3">
                        <label for="main_image" class="fw-bold">Main Photo</label><br>
                        @if ($item->mainPhoto)
                            <img src="{{ asset('storage/' . $item->mainPhoto->path) }}" width="150"
                                class="img-thumbnail mb-2 shadow-sm">
                        @endif
                        <input type="file" class="form-control @error('main_image') is-invalid @enderror"
                            name="main_image" id="main_image">
                        <small class="text-muted">Change Main Photo</small>
                        @error('main_image')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div id="main-preview" class="mt-3"></div>

                    {{-- Gallery --}}
                    <div class="form-group mb-3">
                        <label class="fw-bold">Item Gallery</label><br>

                        {{-- old images --}}
                        <div class="mb-3">
                            @foreach ($item->gallery as $image)
                                <div class="d-inline-block text-center me-2">
                                    <img src="{{ asset('storage/' . $image->path) }}" width="120"
                                        class="img-thumbnail mb-1 shadow-sm">
                                    <div>
                                        <input type="checkbox" name="delete_gallery[]" value="{{ $image->id }}">
                                        <small>Delete</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- new uploads --}}
                        <input type="file" class="form-control @error('gallery.*') is-invalid @enderror"
                            name="gallery[]" id="gallery" multiple>
                        <small class="text-muted">  Add New Photo To Gallary</small>
                        @error('gallery.*')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- preview area --}}
                    <div class="row mt-3" id="gallery-preview"></div>
                </form>
            </div>

            <div class="card-footer clearfix">
                <x-form-submit text="Update"></x-form-submit>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // -------- Gallery Preview (for new images only) --------
        const input = document.getElementById('gallery');
        const preview = document.getElementById('gallery-preview');
        let selectedFiles = [];

        input.addEventListener('change', (event) => {
            const files = Array.from(event.target.files);
            preview.innerHTML = '';
            selectedFiles = [];

            files.forEach((file) => {
                if (!file.type.startsWith('image/')) return;
                selectedFiles.push(file);

                const reader = new FileReader();
                reader.onload = (e) => {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('position-relative', 'd-inline-block', 'me-2', 'mb-2');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail', 'shadow-sm');
                    img.style.width = '120px';
                    img.style.height = '120px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '10px';

                    wrapper.appendChild(img);
                    preview.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        });

        // -------- Main Photo Preview --------
        const mainInput = document.getElementById('main_image');
        const mainPreview = document.getElementById('main-preview');

        mainInput.addEventListener('change', (e) => {
            mainPreview.innerHTML = '';
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (ev) => {
                    const img = document.createElement('img');
                    img.src = ev.target.result;
                    img.classList.add('img-thumbnail', 'shadow-sm');
                    img.style.width = '150px';
                    img.style.height = '150px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '10px';
                    mainPreview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
