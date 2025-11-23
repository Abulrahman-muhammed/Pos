<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Item;
use App\Models\Client;
use App\Models\Safe;
use App\Models\Unit;
use App\Enums\ItemStatusEnum;
use App\Enums\ClientStatusEnum;
use App\Enums\SafeStatusEnum;
use App\Enums\UnitStatusEnum;
use App\Enums\DiscountTypeEnum;
use App\Services\SafeService;
use App\Services\StockMangmentService;
use App\Models\Warehouse;
use App\Enums\WarehouseStatusEnum;


use DB;
use App\Http\Requests\Admin\SaleRequest;
class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::paginate();
        return view('admin.sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::where('status', ItemStatusEnum::Active->value)->get();
        $clients = Client::where('status', ClientStatusEnum::Active->value)->get();
        $safes = Safe::where('status', SafeStatusEnum::Active->value)->get();
        $units = Unit::where('status', UnitStatusEnum::Active->value)->get();
        $warehouses =Warehouse::where('status',WarehouseStatusEnum::Active->value)->get();
        $discountTypes = DiscountTypeEnum::labels();
        return view('admin.sales.create', compact('items', 'clients', 'safes', 'units', 'discountTypes','warehouses'));
    }

    public function store(SaleRequest $request)
    {
        DB::beginTransaction();
        $sale = auth()->user()->sales()->create($request->validated());
        $totalPrice = $this->attachItems($request,$sale);
        $this->updateSaleTotals( $sale, $totalPrice, $request);
        //update safe balance from SafeService class inTransaction method
        $safeService = new SafeService();
        $safeService->inTransaction($sale, $sale->paid_amount, "Sale Payment, Invoice #: {$sale->invoice_number}");
        $this->updateClientAccountBalance($sale);
        DB::commit();
        return back();
    }


private function updateClientAccountBalance(Sale $sale): void
    {
        $balance = $sale->net_amount - $sale->paid_amount;
        if($balance != 0){
            $sale->client->increment('balance', $balance);
        }
        $sale->clientAccountTransactions()->create([
                'user_id' => auth()->user()->id,
                'client_id' => $sale->client_id,
                'credit' => $sale->net_amount,
                'debit' => $sale->paid_amount,
                'balance' =>$balance,
                'balance_after' => $sale->client->fresh()->balance,
                'description' =>"Sale remaining Amount, Invoice #: {$sale->invoice_number}",
        ]);
    }

    private function attachItems(SaleRequest $request,Sale $sale): float
    {
        $totalPrice = 0;

        foreach ($request->items as $item) {
            $queryItem = Item::find($item['id']);
            $totalItemPrice = $queryItem->price * $item['quantity'];

            $sale->items()->attach([
                $item['id'] => [
                    'unit_price' => $queryItem->price,
                    'quantity' => $item['quantity'],
                    'total_price' => $totalItemPrice,
                    'note' => $item['note']
                ]
                ]);
            // $queryItem->decrement('quantity', $item['quantity']);
            (new StockMangmentService())->decreaseStock(
                $queryItem,
                $request->warehouse_id,
                $item['quantity'],
                $sale
            );
            $totalPrice += $totalItemPrice;
        }
        return $totalPrice;
    }


//calculate discount method
    private function calculateDiscount(SaleRequest $request,float $totalPrice): float
    {
        if($request->discount_type == DiscountTypeEnum::Percentage->value){
            $discount = ($totalPrice * $request->discount_value) / 100;
        } else {
            $discount = $request->discount_value;
        }
        return $discount;
    }


    private function updateSaleTotals(Sale $sale, float|int $totalPrice, SaleRequest $request): void
    {
        $discount = $this->calculateDiscount($request,$totalPrice);
        $net = $totalPrice - $discount;

        if($request->payment_type == \App\Enums\PaymentTypeEnum::Cash->value){
            $paid = $net;
            $remaining = 0;
        } else {
            $paid = $request->payment_amount;
            $remaining = $net - $paid;
        }

        $sale->update([
            'total' => $totalPrice,
            'discount' => $discount,
            'net_amount' => $net,
            'paid_amount' => $paid,
            'remaining_amount' => $remaining,
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
