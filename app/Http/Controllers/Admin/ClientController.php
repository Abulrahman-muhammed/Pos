<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Http\Requests\Admin\ClientStoreRequest;
use App\Http\Requests\Admin\ClientUpdateRequest;
use App\Enums\ClientStatusEnum;
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::paginate();
        return view('admin.clients.index', compact('clients'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientStatus = ClientStatusEnum::labels();
        return view('admin.clients.create', compact('clientStatus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientStoreRequest $request)
    {
        // dd($request->validated());
        $client = Client::create($request->validated());
        return redirect()->route('admin.clients.index')->with('success', 'Client created successfully.');
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
        $client = Client::findOrFail($id);
        $clientStatus = ClientStatusEnum::labels();
        return view('admin.clients.edit', compact('client', 'clientStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientUpdateRequest $request, string $id)
    {
        $client = Client::findOrFail($id);
        $client->update($request->validated());
        return redirect()->route('admin.clients.index')->with('success', 'Client updated successfully.');   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return  response()->json([
            'status' => 'success',
            'message' => 'Client deleted successfully.'
        ]);
    }
}
