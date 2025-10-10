<?php

namespace App\Http\Controllers\Admin;
use App\Enums\UserStatusEnum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate();
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userStatuses = UserStatusEnum::labels();
        return view('admin.users.create', compact('userStatuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
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
        $user = User::findOrFail($id);
        $userStatuses = UserStatusEnum::labels();
        return view('admin.users.edit', compact('user', 'userStatuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        if(empty($data['password'])){
            unset($data['password']);
        }
        else{
            $data['password'] = Hash::make($data['password']);
        }
        // dd($data);
        $user = User::findOrFail($id);
        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully.'
        ]);
    }
}
