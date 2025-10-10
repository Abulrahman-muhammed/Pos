@extends('admin.layouts.app', [
    'pageName' => 'sales',
])
@section('dashboard-menu-open', 'menu-open')
@section('create-sale-active', 'active menu-open')

@section('content')
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sales Create</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.sales.store') }}" id="main-form">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="client_id">Client</label>
                                    <select
                                        name="client_id"
                                        id="client_id"
                                        class="form-control select2 @error('client_id') is-invalid @enderror">
                                        <option value="">-- Select Client --</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="sale_date">Date</label>
                                    <input
                                        type="text"
                                        class="form-control datepicker @error('sale_date') is-invalid @enderror"
                                        id="sale_date"
                                        placeholder="Enter sale date"
                                        name="sale_date">
                                    @error('sale_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="invoice_number">Invoice Number</label>
                                    <input
                                        type="text"
                                        class="form-control @error('invoice_number') is-invalid @enderror"
                                        id="invoice_number"
                                        placeholder="Enter invoice number"
                                        name="invoice_number">
                                    @error('invoice_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="safe_id">Safe</label>
                                    <select
                                        name="safe_id"
                                        id="safe_id"
                                        class="form-control select2 @error('safe_id') is-invalid @enderror">
                                        @foreach($safes as $safe)
                                            <option value="{{ $safe->id }}">{{ $safe->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('safe_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="item_id">Item</label>
                                    <select
                                        id="item_id"
                                        class="form-control select2">
                                        <option value="">-- Select Item --</option>
                                        @foreach($items as $item)
                                            <option
                                                data-price="{{$item->price}}"
                                                data-quantity="{{$item->quantity}}"
                                                    value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="qty">Quantity</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="qty"
                                            placeholder="Enter quantity">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="notes"
                                        placeholder="Enter notes">
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <button
                                    type="button"
                                    id="add_item"
                                    class="btn btn-primary mb-2 btn-block"
                                    style="margin-top: 32px">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" style="width: 40px">#</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th style="width: 120px">Qnt</th>
                                    <th>Total</th>
                                    <th>Notes</th>
                                </tr>
                                <tbody id="items_list">

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total</th>
                                    <th id="total_price">0</th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">Discount</th>
                                    <th id="discount_amount">0</th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">Net Amount</th>
                                    <th id="net_amount">0</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="discount-box">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="discount_type">Discount Type</label>
                                        @foreach($discountTypes as $value => $label)
                                            <div class="form-check">
                                                <input 
                                                    class="form-check-input" 
                                                    type="radio" 
                                                    name="discount_type" 
                                                    value="{{ $value }}"
                                                    @checked(old('discount_type', App\Enums\DiscountTypeEnum::Percentage->value) == $value)
                                                >
                                                <label class="form-check-label">{{ $label }}</label>
                                            </div>
                                        @endforeach
                                    
                                        @error('discount_type')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="discount">Discount Value</label>
                                        <input type="number" class="form-control" id="discount" name="discount" value="{{ old('discount')}}" step="0.01" placeholder="Enter discount value">
                                    </div>
                                    @error('discount')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                </div>
            </div>
            <!-- /.card -->
        </div>
@endsection
@push('scripts')
    <script>
        var counter = 1
        var totalPrice = 0;
        $("#add_item").on('click', function (e) {
            e.preventDefault();
            let item = $("#item_id");
            let itemID = item.val();
            let selectedItem = $("#item_id option:selected");
            let itemName = selectedItem.text()
            let itemPrice = selectedItem.data('price');
            let qnt = $("#qty")
            var itemQty = qnt.val();
            let notes = $("#notes")
            let itemNotes = notes.val();
            let itemTotal = itemPrice * itemQty;

            // validate inputs : item chosen , qnt , qnt > 0 , qnt <= available qnt
            if (!itemID) {
                // sweelalet error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please choose an item',
                })
                return;
            }
            if (!itemQty || itemQty <= 0 || itemQty > selectedItem.data('quantity')) {
                // sweelalet error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please enter a valid quantity',
                })
                return;
            }

            $("#items_list").append('' +
                '<tr>' +
                '<td>' + counter + '</td>' +
                '<td>' + itemName +'<input type="hidden" name="items[]" value="'+itemID+'">' + '</td>' +
                '<td>' + itemPrice +'<input type="hidden" name="prices[]" value="'+itemPrice+'">' + '</td>' +
                '<td>' + '<input type="number" class="form-control" name="quantities[]"value="'+itemQty+'" >' +'</td>' +
                '<td>' + itemTotal + '</td>' +
                '<td>' + itemNotes +  '<input type="hidden" name="notes[]"value="'+itemNotes+'" >' +'</td>' +
                '<td>' + '<button onclick="deleteItem(event)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>' + '</td>' +
                '</tr>');
            counter++

            totalPrice += itemTotal;
            $("#total_price").text(totalPrice);
            calculateDiscount();


            item.val("").trigger('change')
            qnt.val("")
            notes.val("")
        })

        $("#discount").on('keyup', function (e) {
            e.preventDefault();
            calculateDiscount();
        })
        $('input[name="discount_type"]').on('change', function (e) {
            e.preventDefault();
            calculateDiscount();
        })


        function calculateDiscount() {
            let discountType = $('input[name="discount_type"]:checked').val();
            let discount = $("#discount").val();
            if (discountType == {{ App\Enums\DiscountTypeEnum::Percentage->value }}) {
                discount = Math.round(totalPrice * discount / 100, 2);
                $("#discount_amount").text(Math.round(discount, 2));
            } else if (discountType == {{ App\Enums\DiscountTypeEnum::Fixed->value }}) {
                discount = Math.round(discount, 2);
                $("#discount_amount").text(Math.round(discount, 2));
            } else {
                discount = 0;
                $("#discount_amount").text(Math.round(discount, 2));
            }
            let netAmount = Math.round(totalPrice - discount, 2);
            $("#net_amount").text(Math.round(netAmount, 2));
        }
        function deleteItem(event) {
            let itemTotal = $(event.target).closest("tr").find("td:nth-child(5)").text();
            totalPrice -= itemTotal;
            $("#total_price").text(totalPrice);
            calculateDiscount();
            $(event.target).closest("tr").remove();
            counter--;
        }
    </script>
@endpush