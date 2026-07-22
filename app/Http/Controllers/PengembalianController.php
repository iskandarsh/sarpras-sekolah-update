<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::with('peminjaman.barang')->latest()->get();

        $peminjaman = Peminjaman::where('status', 'Dipinjam')->get();

        return view('pengembalian.index', compact('pengembalian', 'peminjaman'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $request->validate([
            'peminjaman_id' => 'required',
            'tanggal_pengembalian' => 'required|date',
            'keterangan' => 'nullable',
        ]);

        Pengembalian::create([
            'peminjaman_id' => $request->peminjaman_id,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'keterangan' => $request->keterangan,
        ]);

        $pinjam = Peminjaman::find($request->peminjaman_id);

        // Tambahkan kembali stok barang
        $barang = Barang::find($pinjam->barang_id);

        $barang->update([
            'jumlah' => $barang->jumlah + $pinjam->jumlah
        ]);

        // Ubah status peminjaman
        $pinjam->update([
            'status' => 'Dikembalikan'
        ]);

        return back()->with('success', 'Data pengembalian berhasil ditambahkan.');
    }

    public function update(Request $request, Pengembalian $pengembalian)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $request->validate([
            'tanggal_pengembalian' => 'required|date',
            'keterangan' => 'nullable',
        ]);

        $pengembalian->update([
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Data pengembalian berhasil diubah.');
    }

    public function destroy(Pengembalian $pengembalian)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $peminjaman = $pengembalian->peminjaman;

        // Kurangi lagi stok barang karena pengembalian dibatalkan
        $barang = Barang::find($peminjaman->barang_id);

        $barang->update([
            'jumlah' => $barang->jumlah - $peminjaman->jumlah
        ]);

        $pengembalian->delete();

        $peminjaman->update([
            'status' => 'Dipinjam'
        ]);

        return back()->with('success', 'Data pengembalian berhasil dihapus.');
    }
}
