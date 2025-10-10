<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Enums\UnitStatusEnum;
use App\Http\Requests\Admin\UnitStoreRequest;
use App\Http\Requests\Admin\UnitUpdateRequest;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::paginate();
        return view('admin.units.index',compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unitStatus = UnitStatusEnum::labels();
        return view('admin.units.create',compact('unitStatus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitStoreRequest $request)
    {
        Unit::create($request->validated());
        return redirect()->route('admin.units.index')->with('success', 'Unit created successfully .');
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
        $unit = Unit::findOrFail($id);
        $unitStatus = UnitStatusEnum::labels();
        return view('admin.units.edit',compact('unit','unitStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnitUpdateRequest $request, string $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->update($request->validated());
        return redirect()->route('admin.units.index')->with('success', 'Unit Updated successfully .');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Unit::findOrFail($id);
        
        if ($unit->items()->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete category because it has items linked to it.'
            ], 400);
        }

        $unit->delete();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Unit deleted successfully.'
        ]);
    }
}
