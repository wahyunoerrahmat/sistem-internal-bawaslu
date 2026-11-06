<?php

namespace App\Http\Controllers\Absensi\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;

class AbsensiController extends Controller
{
    public function index()
    {
        $data = Absensi::with('user')->latest()->get();
        return view('absensi.admin.index', compact('data'));
    }

    public function create()
    {
        $users = User::all();
        return view('absensi.admin.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'tanggal'   => 'required|date',
            'jam_masuk' => 'nullable',
            'jam_pulang'=> 'nullable',
            'status'    => 'required',
        ]);

        Absensi::create($request->all());

        return redirect()->route('absensi.admin.data.index')
            ->with('success', 'Data absensi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Absensi::findOrFail($id);
        $users = User::all();

        return view('absensi.admin.edit', compact('data', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'tanggal'   => 'required|date',
            'jam_masuk' => 'nullable',
            'jam_pulang'=> 'nullable',
            'status'    => 'required',
        ]);

        $data = Absensi::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('absensi.admin.data.index')
            ->with('success', 'Data absensi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = Absensi::findOrFail($id);
        $data->delete();

        return redirect()->route('absensi.admin.data.index')
            ->with('success', 'Data absensi berhasil dihapus');
    }

    public function laporan(Request $request)
    {
        $query = Absensi::with('user');

        // filter tanggal mulai
        if ($request->tanggal_mulai) {
            $query->whereDate('jam_masuk', '>=', $request->tanggal_mulai);
        }

        // filter tanggal akhir
        if ($request->tanggal_akhir) {
            $query->whereDate('jam_masuk', '<=', $request->tanggal_akhir);
        }

        // filter user
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $data = $query->latest()->get();

        // ambil semua user untuk dropdown filter
        $users = User::orderBy('name')->get();

        return view('absensi.admin.laporan', compact('data','users'));
    }
}