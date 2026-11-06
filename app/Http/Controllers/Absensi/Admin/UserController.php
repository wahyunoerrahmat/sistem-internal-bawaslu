<?php

namespace App\Http\Controllers\Absensi\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['magang'])->get();
        return view('absensi.admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('absensi.admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:magang'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->route('absensi.admin.users.index')
            ->with('success', 'Akun berhasil dibuat');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('absensi.admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required|in:magang',
            'password' => 'nullable|min:6'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ];

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('absensi.admin.users.index')
            ->with('success', 'Akun berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('absensi.admin.users.index')
            ->with('success', 'Akun berhasil dihapus');
    }
}
