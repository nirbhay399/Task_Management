<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // $this->authorize('viewAny', User::class);
        if (auth()->user()->role === 'Admin' || $this->authorize('viewAny', User::class)){ 
            $users = User::all();
            return view('admin.users.index', compact('users'));
        }    
    }

    public function edit(User $user)
    {
        if (auth()->user()->role === 'Admin' || $this->authorize('update', $user))
        return view('admin.users.edit', compact('user'));
    }

    // public function update(Request $request, User $user)
    // {
    //     $this->authorize('update', $user);

    //     $request->validate([
    //         'role' => 'required|string',
    //         'permissions' => 'nullable|array',
    //     ]);

    //     $user->update([
    //         'role' => $request->role,
    //         'permissions' => json_encode($request->permissions),
    //     ]);

    //     return redirect()->route('admin.users.index');
    // }
    public function update(Request $request, User $user)
    {
        // Check if the user is authorized to perform the update action or has the role of 'admin'
        if (auth()->user()->role === 'Admin' || $this->authorize('update', $user)) {
            $request->validate([
                'role' => 'required|string',
                'permissions' => 'nullable|array',
            ]);

            $user->update([
                'role' => $request->role,
                'permissions' => json_encode($request->permissions),
            ]);

            return redirect()->route('admin.users.index');
        } else {
            // Handle unauthorized access
            abort(403, 'Unauthorized');
        }
    }

    
}

