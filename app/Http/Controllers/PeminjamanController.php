<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with('barang');

        // Search nama peminjam
        if ($request->search) {
            $query->where('nama_peminjam', 'like', '%' . $request->search . '%');
        }

        // Filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->latest()->get();
        $barang = Barang::all();

        return view('peminjaman.index', compact('peminjaman', 'barang'));
    }
    public function store(Request $request)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $request->validate([
            'nama_peminjam' => 'required',
            'barang_id' => 'required',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date',
            'status' => 'required',
            'keterangan' => 'nullable',
        ]);

        $barang = Barang::find($request->barang_id);

        if ($request->jumlah > $barang->jumlah) {
            return back()->with('error', 'Stok barang tidak mencukupi.');
        }

        // Simpan data peminjaman
        Peminjaman::create($request->all());

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Menambahkan peminjaman oleh "' . $request->nama_peminjam . '"',
        ]);

        // Kurangi stok barang
        $barang = Barang::find($request->barang_id);

        $barang->update([
            'jumlah' => $barang->jumlah - $request->jumlah
        ]);

        return back()->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $request->validate([
            'nama_peminjam' => 'required',
            'barang_id' => 'required',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date',
            'status' => 'required',
            'keterangan' => 'nullable',
        ]);

        $barang = Barang::find($request->barang_id);

        if ($request->jumlah > $barang->jumlah) {
            return back()->with('error', 'Stok barang tidak mencukupi.');
        }

        $peminjaman->update($request->all());

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Mengubah data peminjaman "' . $peminjaman->nama_peminjam . '"',
        ]);

        return back()->with('success', 'Data peminjaman berhasil diubah.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Menghapus data pengembalian',
        ]);

        $peminjaman->delete();

        return back()->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
