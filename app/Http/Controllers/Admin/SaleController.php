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
        $discountTypes = DiscountTypeEnum::labels();
        return view('admin.sales.create', compact('items', 'clients', 'safes', 'units', 'discountTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
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
