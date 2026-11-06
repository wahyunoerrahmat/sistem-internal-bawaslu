<?php

namespace App\Http\Controllers\Barang\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Daftar pegawai
     */
    public function index()
    {
        $users = User::where('role', 'pegawai')->latest()->get();

        return view('barang.admin.user.index', compact('users'));
    }

    /**
     * Form tambah pegawai
     */
    public function create()
    {
        return view('barang.admin.user.create');
    }

    /**
     * Simpan pegawai
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pegawai',
        ]);

        return redirect()
            ->route('barang.admin.user.index')
            ->with('success', 'Pegawai berhasil ditambahkan');
    }

    /**
     * Form edit
     */
    public function edit(User $user)
    {
        return view('barang.admin.user.edit', compact('user'));
    }

    /**
     * Update pegawai
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('barang.admin.user.index')
            ->with('success', 'Pegawai berhasil diperbarui');
    }

    /**
     * Hapus pegawai
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('barang.admin.user.index')
            ->with('success', 'Pegawai berhasil dihapus');
    }
}
