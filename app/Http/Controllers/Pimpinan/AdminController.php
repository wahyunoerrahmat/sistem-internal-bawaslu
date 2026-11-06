<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::whereIn('role', [
            'admin_absensi',
            'admin_barang',
            'resepsionis'
        ])->get();

        return view('pimpinan.admin.index', compact('admins'));
    }

    public function create()
    {
        return view('pimpinan.admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin_absensi,admin_barang,resepsionis'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()
            ->route('pimpinan.admin.index')
            ->with('success', 'Admin berhasil ditambahkan');
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('pimpinan.admin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $admin->id,
            'role'     => 'required|in:admin_absensi,admin_barang',
            'password' => 'nullable|min:6'
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()
            ->route('pimpinan.admin.index')
            ->with('success', 'Admin berhasil diperbarui');
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);

        // Cegah hapus akun sendiri
        if (auth()->id() == $admin->id) {
            return redirect()
                ->route('pimpinan.admin.index')
                ->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        $admin->delete();

        return redirect()
            ->route('pimpinan.admin.index')
            ->with('success', 'Admin berhasil dihapus');
    }
}
