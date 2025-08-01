<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserManagementController extends Controller
{
    public function index()
    {
        Log::channel('admin')->info('SuperAdmin accessed user list', [
            'admin' => auth()->user()->email,
            'ip' => request()->ip(),
            'time' => now()->toDateTimeString()
        ]);

        $users = User::with('roles')->latest()->paginate(10);
        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
        Log::channel('admin')->debug('SuperAdmin accessed user creation form', [
            'admin' => auth()->user()->email
        ]);

        $roles = Role::all();
        return view('superadmin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $role = Role::findOrFail($validated['role_id']);
            $user->roles()->attach($role->id);

            Log::channel('admin')->info('User created successfully', [
                'admin' => auth()->user()->email,
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $role->name,
                'ip' => request()->ip(),
                'timestamp' => now()->toDateTimeString()
            ]);

            return redirect()->route('superadmin.users.index')
                ->with('success', "User {$user->email} created successfully with {$role->name} role.");

        } catch (\Exception $e) {
            Log::channel('admin')->error('User creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()
                ->with('error', 'User creation failed: ' . $e->getMessage());
        }
    }


    public function edit(User $user)
    {
        Log::channel('admin')->debug('SuperAdmin editing user', [
            'admin' => auth()->user()->email,
            'user_edited' => $user->email
        ]);

        $roles = Role::all();
        return view('superadmin.users.create', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        try {
            $updateData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            if ($validated['password']) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            $oldRole = $user->roles->first()->name ?? 'none';
            $newRole = Role::find($validated['role_id'])->name;

            $user->update($updateData);
            $user->roles()->sync([$validated['role_id']]);

            Log::channel('admin')->info('User updated successfully', [
                'admin' => auth()->user()->email,
                'user_id' => $user->id,
                'changes' => [
                    'name' => ['old' => $user->getOriginal('name'), 'new' => $validated['name']],
                    'email' => ['old' => $user->getOriginal('email'), 'new' => $validated['email']],
                    'role' => ['old' => $oldRole, 'new' => $newRole]
                ],
                'ip' => request()->ip(),
                'timestamp' => now()->toDateTimeString()
            ]);

            return redirect()->route('superadmin.users.index')
                ->with('success', "User {$user->email} updated successfully.");

        } catch (\Exception $e) {
            Log::channel('admin')->error('User update failed', [
                'admin' => auth()->user()->email,
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'input' => $request->except('password', 'password_confirmation'),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'User update failed. Please try again.');
        }
    }

    public function destroy(User $user)
    {
        try {
            $userEmail = $user->email;
            $user->delete();

            Log::channel('admin')->warning('User deleted', [
                'admin' => auth()->user()->email,
                'deleted_user' => $userEmail,
                'ip' => request()->ip(),
                'timestamp' => now()->toDateTimeString()
            ]);

            return redirect()->route('superadmin.users.index')
                ->with('success', "User {$userEmail} deleted successfully.");

        } catch (\Exception $e) {
            Log::channel('admin')->error('User deletion failed', [
                'admin' => auth()->user()->email,
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'User deletion failed. Please try again.');
        }
    }
}