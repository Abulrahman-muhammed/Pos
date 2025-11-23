@extends('admin.layouts.app', [
    'pageName' => 'Items',
])

@section('content')
    <style>
        .uniform-input {
            height: 42px !important;
        }
    </style>

    <div class="col-sm-12">
        <div class="card shadow-sm rounded-3">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Create Item</h3>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.items.store') }}" id="main-form" enctype="multipart/form-data">
                    @csrf

                    {{-- Item Name --}}
                    <div class="form-group mb-3">
                        <label for="name" class="fw-bold">Item Name</label>
                        <input class="form-control uniform-input @error('name') is-invalid @enderror" id="name"
                            name="name" placeholder="Enter item name" value="{{ old('name') }}">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Item Code --}}
                    <div class="form-group mb-3">
                        <label for="item_code" class="fw-bold">Item Code</label>
                        <input class="form-control uniform-input @error('item_code') is-invalid @enderror" id="item_code"
                            name="item_code" placeholder="Enter item code" value="{{ old('item_code') }}">
                        @error('item_code')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group mb-3">
                        <label for="description" class="fw-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="3" placeholder="Enter description">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Price / Quantity / Warehouse / Minimum Stock --}}
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="price" class="fw-bold">Price</label>
                            <input type="number" step="0.01"
                                class="form-control uniform-input @error('price') is-invalid @enderror" id="price"
                                name="price" value="{{ old('price') }}">
                            @error('price')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="quantity" class="fw-bold">Quantity</label>
                            <input type="number" step="0.01"
                                class="form-control uniform-input @error('quantity') is-invalid @enderror" id="quantity"
                                name="quantity" value="{{ old('quantity') }}">
                            @error('quantity')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="warehouse_id" class="fw-bold">Warehouse</label>
                            <select name="warehouse_id"
                                class="form-control uniform-input select2 @error('warehouse_id') is-invalid @enderror">
                                <option value="" selected>-- Select Warehouse --</option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}" @selected(old('warehouse_id') == $warehouse->id)>
                                        {{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('warehouse_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="minimum_stock" class="fw-bold">Minimum Stock</label>
                            <input type="number" step="0.01"
                                class="form-control uniform-input @error('minimum_stock') is-invalid @enderror"
                                id="minimum_stock" name="minimum_stock" value="{{ old('minimum_stock') }}">
                            @error('minimum_stock')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Category & Unit --}}
                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label for="category_id" class="fw-bold">Category</label>
                            <select name="category_id"
                                class="form-control uniform-input select2 @error('category_id') is-invalid @enderror">
                                <option value="" selected>-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="unit_id" class="fw-bold">Unit</label>
                            <select name="unit_id"
                                class="form-control uniform-input select2 @error('unit_id') is-invalid @enderror">
                                <option value="" selected>-- Select Unit --</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}" @selected(old('unit_id') == $unit->id)>
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
                    <div class="form-group mb-3 mt-3">
                        <label class="fw-bold">Status</label>
                        <div>
                            @foreach ($itemStatus as $value => $label)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status"
                                        value="{{ $value }}" @if ($loop->first) checked @endif
                                        @checked(old('status') == $value)>
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
                                {{ old('is_shown_in_store') ? 'checked' : '' }}>
                            Show in Store
                        </label>
                    </div>

                    {{-- Main Photo --}}
                    <div class="form-group mb-3">
                        <label for="main_image" class="fw-bold">Main Photo</label>
                        <input type="file" class="form-control @error('main_image') is-invalid @enderror"
                            name="main_image" id="main_image">
                        <small class="text-muted">Upload the main image of the item</small>
                        @error('main_image')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div id="main-preview" class="mt-3"></div>

                    {{-- Gallery --}}
                    <div class="form-group mb-3">
                        <label for="gallery" class="fw-bold">Item Gallery</label>
                        <input type="file" class="form-control @error('gallery.*') is-invalid @enderror"
                            name="gallery[]" id="gallery" multiple>
                        <small class="text-muted">You can upload multiple gallery images</small>
                        @error('gallery.*')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row mt-3" id="gallery-preview"></div>
                </form>
            </div>

            <div class="card-footer clearfix">
                <x-form-submit text="Create"></x-form-submit>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // ----------------- Gallery Preview -----------------
        const input = document.getElementById('gallery');
        const preview = document.getElementById('gallery-preview');

        let selectedFiles = [];

        input.addEventListener('change', (event) => {
            const files = Array.from(event.target.files);

            files.forEach((file) => {
                if (!file.type.startsWith('image/')) return;

                selectedFiles.push(file);

                const reader = new FileReader();
                reader.onload = (e) => {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('position-relative', 'd-inline-block');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail', 'shadow-sm');
                    img.style.width = '180px';
                    img.style.height = '180px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '10px';

                    // زرار الحذف ❌
                    const btn = document.createElement('button');
                    btn.innerHTML = '&times;';
                    btn.type = 'button';
                    btn.classList.add(
                        'btn',
                        'btn-sm',
                        'btn-danger',
                        'rounded-circle',
                        'position-absolute',
                        'd-flex',
                        'align-items-center',
                        'justify-content-center'
                    );
                    btn.style.top = '5px';
                    btn.style.right = '5px';
                    btn.style.width = '28px';
                    btn.style.height = '28px';
                    btn.style.padding = '0';
                    btn.style.fontSize = '16px';
                    btn.style.lineHeight = '1';

                    btn.addEventListener('click', () => {
                        const index = selectedFiles.indexOf(file);
                        if (index > -1) {
                            selectedFiles.splice(index, 1);
                            updateInputFiles();
                        }
                        wrapper.remove();
                    });

                    wrapper.appendChild(img);
                    wrapper.appendChild(btn);
                    preview.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });

            updateInputFiles();
        });

        function updateInputFiles() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            input.files = dataTransfer.files;
        }

        // ----------------- Main Photo Preview -----------------
        const mainInput = document.getElementById('main_image');
        const mainPreview = document.getElementById('main-preview');

        mainInput.addEventListener('change', (e) => {
            mainPreview.innerHTML = ''; // امسح أي بريفيو قديم
            const file = e.target.files[0];

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (ev) => {
                    const img = document.createElement('img');
                    img.src = ev.target.result;
                    img.classList.add('img-thumbnail', 'shadow-sm');
                    img.style.width = '200px';
                    img.style.height = '200px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '10px';

                    mainPreview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
