<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Display a listing of the users
    public function index()
    {
        $data['users'] = User::all();
        return view('users.index', $data);
    }

    // Show the form for creating a new user
    public function create()
    {
        $data['roles'] = Role::all();
        return view('users.create', $data);
    }

    // Store a newly created user in storage
    public function store(UserRequest $request)
    {
        dd('test');
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->role_id;
        $user->save();
        dd($user);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully.',
            'redirect_url' => route('users.index')
        ]);

        // return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Show the form for editing the specified user
    public function edit($id)
    {
        $data['user'] = User::findOrFail($id);
        return view('users.edit', $data);
    }

    // Update the specified user in storage
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Remove the specified user from storage
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.'
        ]);
    }

}
