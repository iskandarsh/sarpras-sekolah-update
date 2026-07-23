<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Role
        if ($request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->get();

        return view('user.index', compact('users'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Menambahkan user "' . $request->name . '"',
        ]);

        return back()->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Mengubah user "' . $user->name . '"',
        ]);

        return back()->with('success', 'User berhasil diubah.');
    }

    public function destroy(User $user)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Menghapus user "' . $user->name . '"',
        ]);

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
}
