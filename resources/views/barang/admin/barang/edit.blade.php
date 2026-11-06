@extends('layouts.admin-barang')

@section('title', 'Edit Barang')

@section('content')

<div class="page-header">
    <h2>Edit Barang</h2>
</div>

<div class="card">

    <form action="{{ route('barang.admin.barang.update', $barang->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>No Urut</label>
            <input type="number" name="no_urut"
                   value="{{ old('no_urut', $barang->no_urut) }}">
        </div>

        <div class="form-group">
            <label>Jenis Barang</label>
            <input type="text" name="jenis_barang"
                   value="{{ old('jenis_barang', $barang->jenis_barang) }}" required>
        </div>

        <div class="form-group">
            <label>NUP</label>
            <input type="text" name="nup"
                   value="{{ old('nup', $barang->nup) }}" required>
        </div>

        <div class="form-group">
            <label>Merk</label>
            <input type="text" name="merk"
                   value="{{ old('merk', $barang->merk) }}">
        </div>

        <div class="form-group">
            <label>Tipe</label>
            <input type="text" name="tipe"
                   value="{{ old('tipe', $barang->tipe) }}">
        </div>

        <div class="form-group">
            <label>Kondisi</label>
            <select name="kondisi">
                <option value="Baik" {{ $barang->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                <option value="Rusak Ringan" {{ $barang->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                <option value="Rusak Berat" {{ $barang->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
            </select>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status">
                <option value="Tersedia" {{ $barang->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="Dipinjam" {{ $barang->status == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
            </select>
        </div>

        <div class="form-actions">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('barang.admin.barang.index') }}" class="btn btn-warning">
                Batal
            </a>
        </div>

    </form>

</div>

@endsection