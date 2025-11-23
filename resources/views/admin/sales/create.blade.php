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
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="client_id">Client</label>
                                <select name="client_id" id="client_id"
                                    class="form-control select2 @error('client_id') is-invalid @enderror">
                                    <option value="">-- Select Client --</option>
                                    @foreach ($clients as $client)
                                        <option {{ old('client_id') == $client->id ? 'selected' : '' }}
                                            value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="sale_date">Date</label>
                                <input type="text"
                                    class="form-control datepicker @error('sale_date') is-invalid @enderror" id="sale_date"
                                    placeholder="Enter sale date" name="sale_date">
                                @error('sale_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="invoice_number">Invoice Number</label>
                                <input type="text" class="form-control @error('invoice_number') is-invalid @enderror"
                                    id="invoice_number" placeholder="Enter invoice number" name="invoice_number">
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
                                <select name="safe_id" id="safe_id"
                                    class="form-control select2 @error('safe_id') is-invalid @enderror">
                                    @foreach ($safes as $safe)
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
                        <div class="col-sm-6">
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
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="item_id">Item</label>
                                <select id="item_id" class="form-control select2">
                                    <option value="">-- Select Item --</option>
                                    @foreach ($items as $item)
                                        <option data-price="{{ $item->price }}" data-quantity="{{ $item->quantity }}"
                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="qty">Quantity</label>
                                <input type="text" class="form-control" id="qty" placeholder="Enter quantity">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <input type="text" class="form-control" id="notes" placeholder="Enter notes">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" id="add_item" class="btn btn-primary mb-2 btn-block"
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
                                @foreach ((array) old('items') as $index => $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><span> {{ $item['name'] }} </span>
                                            <input type="hidden" name="items[{{ $item['id'] }}][id]"
                                                value="{{ $item['id'] }}">
                                            <input type="hidden" name="items[{{ $item['id'] }}][name]"
                                                value="{{ $item['name'] }}">
                                        </td>
                                        <td> {{ $item['price'] }}
                                            <input type="hidden" name="items[{{ $item['id'] }}][price]"
                                                value="{{ $item['price'] }}">
                                        </td>
                                        <td><input type="number" class="form-control"
                                                name="items[{{ $item['id'] }}][quantity]"
                                                value="{{ $item['quantity'] }}"></td>
                                        <td>{{ $item['itemTotal'] }}
                                            <input type="hidden" name="items[{{ $item['id'] }}][itemTotal]"
                                                value="{{ $item['itemTotal'] }}">
                                        </td>
                                        <td><span> {{ $item['note'] }} </span> <input type="hidden"
                                                name="items[{{ $item['id'] }}][note]" value="{{ $item['note'] }}">
                                        </td>
                                        <td><button onclick="deleteItem(event)" class="btn btn-danger btn-sm"><i
                                                    class="fas fa-trash"></i></button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total</th>
                                    <th id="total_price">{{ collect(old('items'))->sum('itemTotal') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">Discount</th>
                                    <th id="discount_amount">
                                        {{ old('discount') ?? 0 }}
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">Net Amount</th>
                                    <th id="net_amount">
                                        {{ collect(old('items'))->sum('itemTotal') - (old('discount') ?? 0) }}
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">Paid</th>
                                    <th id="payment_amount"> {{ old('payment_amount') ?? 0 }} </th>

                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">Remaining</th>
                                    <th id="remaining_amount">
                                        {{
                                            collect(old('items'))->sum('itemTotal') -
                                                (old('discount') ?? 0) -
                                                (old('payment_amount') ?? 0)
                                        }}
                                    </th>

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="discount-box">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="discount_type">Discount Type</label>
                                    @foreach ($discountTypes as $value => $label)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="discount_type"
                                                value="{{ $value }}" @checked(old('discount_type', App\Enums\DiscountTypeEnum::Percentage->value) == $value)>
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
                                    <input type="number" class="form-control" id="discount" name="discount_value"
                                        value="{{ old('discount') }}" step="0.01" placeholder="Enter discount value">
                                </div>
                                @error('discount')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="discount-box">
                        {{-- payment type --}}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="payment_type">Payment Type</label>
                                    {{-- radio buttons --}}
                                    @foreach (App\Enums\PaymentTypeEnum::labels() as $value => $label)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_type"
                                                value="{{ $value }}" @checked(old('payment_type', App\Enums\PaymentTypeEnum::Cash->value) == $value)>
                                            <label class="form-check-label">{{ $label }}</label>
                                        </div>
                                    @endforeach
                                    @error('payment_type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                {{-- payment amount input --}}
                                <div class="form-group">
                                    <label for="payment_amount">Payment Amount</label>
                                    <input type="number" class="form-control" id="payment_amount_input" name="payment_amount"
                                        value="{{ old('payment_amount') }}" 
                                        @if(old('payment_type', App\Enums\PaymentTypeEnum::Cash->value) != App\Enums\PaymentTypeEnum::Debit->value){{ 'disabled' }}@endif
                                        step="0.01"
                                        placeholder="Enter payment amount"
                                        >
                                </div>
                                @error('payment_amount')
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
        if ("{{ old('discount') }}" !== "") {
            totalPrice = parseFloat($("#total_price").text());
            calculateDiscount();
        }

        var counter = 1
        var totalPrice = 0;

        $("#add_item").on('click', function(e) {
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
            // if (!itemQty || itemQty <= 0 || itemQty > selectedItem.data('quantity')) {
            //     // sweelalet error
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Error',
            //         text: 'Please enter a valid quantity',
            //     })
            //     return;
            // }

            $("#items_list").append('' +
                '<tr>' +
                '<td>' + counter + '</td>' +
                '<td>' + itemName + '<input type="hidden" name="items[' + counter + '][id]" value="' + itemID +
                '">' + '<input type="hidden" name="items[' + counter + '][name]" value="' + itemName + '">' +
                '</td>' +
                '<td>' + itemPrice + '<input type="hidden" name="items[' + counter + '][price]" value="' +
                itemPrice + '">' + '</td>' +
                '<td>' + '<input type="number" class="form-control" name="items[' + counter +
                '][quantity]"value="' + itemQty + '" >' + '</td>' +
                '<td>' + itemTotal + '<input type="hidden" name="items[' + counter + '][itemTotal]" value="' +
                itemTotal + '">' + '</td>' +
                '<td>' + itemNotes + '<input type="hidden" name="items[' + counter + '][note]"value="' +
                itemNotes + '" >' + '</td>' +
                '<td>' +
                '<button onclick="deleteItem(event)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>' +
                '</td>' +
                '</tr>');
            counter++

            totalPrice += itemTotal;
            $("#total_price").text(totalPrice);
            calculateDiscount();


            item.val("").trigger('change')
            qnt.val("")
            notes.val("")
        })

        $("#discount").on('keyup', function(e) {
            e.preventDefault();
            calculateDiscount();
        })
        $('input[name="discount_type"]').on('change', function(e) {
            e.preventDefault();
            calculateDiscount();
        })


        function calculateDiscount() {
            let discount = 0;
            let discountType = $('input[name="discount_type"]:checked').val();
            let discountInput = parseFloat($("#discount").val()) || 0;

            if (discountType == {{ App\Enums\DiscountTypeEnum::Percentage->value }}) {
                discount = Math.round((totalPrice * discountInput / 100 + Number.EPSILON) * 100) / 100;
            } else if (discountType == {{ App\Enums\DiscountTypeEnum::Fixed->value }}) {
                discount = Math.round((discountInput + Number.EPSILON) * 100) / 100;
            }

            let netAmount = Math.round((totalPrice - discount + Number.EPSILON) * 100) / 100;

            $("#discount_amount").text(discount.toFixed(2));
            $("#net_amount").text(netAmount.toFixed(2));
        }


        function deleteItem(event) {
            let itemTotal = parseFloat($(event.target).closest("tr").find("td:nth-child(5)").text());
            totalPrice -= itemTotal;
            $("#total_price").text(totalPrice);
            calculateDiscount();
            $(event.currentTarget).closest('tr').remove();
            counter--;
        }


    $('input[name="payment_type"]').on('change', function(e) {

        let paymentType = $('input[name="payment_type"]:checked').val();

        let depitValue = "{{ App\Enums\PaymentTypeEnum::Debit->value }}";

        if (paymentType == depitValue) {
            $('#payment_amount_input').attr('disabled', false);

        } else {
            $('#payment_amount_input').val("");
            $('#payment_amount_input').attr('disabled', true);
            calculateRemainingAmount();
        }
    });

    // if payment type is cash on keyup of calculate remaining amount && if payment type is debit paid == net amount
    $('#payment_amount_input').on('keyup', function(e) {
        e.preventDefault();
        calculateRemainingAmount();
    });
    
    function calculateRemainingAmount() {
        let paymentType = parseInt($('input[name="payment_type"]:checked').val());
        let net = parseFloat($("#net_amount").text()) || 0;
        let total = parseFloat($("#total_price").text()) || 0;
        let paid = parseFloat($("#payment_amount_input").val()) || 0;

        if (paymentType === {{ App\Enums\PaymentTypeEnum::Cash->value }}) {
            paid = net;
            $("#payment_amount_input").val(paid.toFixed(2));
        }

        let remaining = net - paid;
        remaining = Math.round((remaining + Number.EPSILON) * 100) / 100;

        $("#payment_amount").text(paid.toFixed(2));
        $("#remaining_amount").text(remaining.toFixed(2));
    }



    </script>
@endpush
