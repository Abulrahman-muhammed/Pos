<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Enums\WarehouseStatusEnum;
use App\Http\Requests\Admin\WarehouseRequest;
class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouses = Warehouse::paginate();
        $warehouseSatatusEnum = WarehouseStatusEnum::values();
        return view('admin.warehouses.index', compact('warehouses', 'warehouseSatatusEnum'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $warehouseSatatusEnum = WarehouseStatusEnum::labels();
        return view('admin.warehouses.create', compact('warehouseSatatusEnum'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WarehouseRequest $request)
    {
        Warehouse::create($request->validated());
        return redirect()->route('admin.warehouses.index')->with('success', 'Warehouse created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouseSatatusEnum = WarehouseStatusEnum::labels();
        return view('admin.warehouses.edit', compact('warehouse', 'warehouseSatatusEnum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WarehouseRequest $request, string $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->update($request->validated());
        return redirect()->route('admin.warehouses.index')->with('success', 'Warehouse updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        if ($warehouse->items()->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete warehouse with associated items.'
            ], 400);
        }
        $warehouse->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Warehouse deleted successfully.'
        ]);
    }
}
