<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // List all users
    public function index()
    {
        $users = User::with('roles')->orderBy('created_at', 'desc')->paginate(10);
        $roles = Role::all();
        return view('users.index', compact('users', 'roles'));
    }

    // Show create form
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    // Store new user
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')
            ->with('success', 'User "' . $user->name . '" created successfully with role: ' . $request->role);
    }

    // Show edit form
    public function edit(User $user)
    {
        $roles = Role::all();
        $currentRole = $user->roles->first()?->name;
        return view('users.edit', compact('user', 'roles', 'currentRole'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role'     => 'required|exists:roles,name',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            ...(filled($request->password) ? ['password' => Hash::make($request->password)] : []),
        ]);

        // Sync role (removes old, assigns new)
        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')
            ->with('success', 'User "' . $user->name . '" updated successfully.');
    }

    // Delete user
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}