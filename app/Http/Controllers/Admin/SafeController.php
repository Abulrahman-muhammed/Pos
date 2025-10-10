<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Safe;
use App\Enums\SafeStatusEnum;
use App\Enums\SafeTypeEnum;
use App\Http\Requests\Admin\safeStoreRequest;
use App\Http\Requests\Admin\safeUpdateRequest;
class SafeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $safes = Safe::paginate();
        return view('admin.safes.index', compact('safes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $safeStatus = SafeStatusEnum::labels();
        $safetypes = SafeTypeEnum::labels();
        return view('admin.safes.create', compact('safeStatus', 'safetypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(safeStoreRequest $request)
    {
        // dd($request->validated());
        $safe = Safe::create($request->validated());
        return redirect()->route('admin.safes.index')->with('success', 'Safe created successfully.');
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
        $safe = Safe::findOrFail($id);
        $safeStatus = SafeStatusEnum::labels();
        $safetypes = SafeTypeEnum::labels();
        return view('admin.safes.edit', compact('safe', 'safeStatus', 'safetypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SafeUpdateRequest $request, string $id)
    {
        $safe = Safe::findOrFail($id);
        $safe->update($request->validated());
        return redirect()->route('admin.safes.index')->with('success', 'Safe updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $safe = Safe::findOrFail($id);
        $safe->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Safe deleted successfully.'
        ]);
    }
}
