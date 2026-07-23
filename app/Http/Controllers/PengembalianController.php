<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengembalian::with('peminjaman');

        // Search nama peminjam
        if ($request->search) {
            $query->whereHas('peminjaman', function ($q) use ($request) {
                $q->where('nama_peminjam', 'like', '%' . $request->search . '%');
            });
        }

        $pengembalian = $query->latest()->get();

        // Untuk dropdown pada modal tambah
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

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Menambahkan data pengembalian',
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

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Mengubah data pengembalian',
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

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Menghapus data pengembalian',
        ]);

        $pengembalian->delete();

        $peminjaman->update([
            'status' => 'Dipinjam'
        ]);

        return back()->with('success', 'Data pengembalian berhasil dihapus.');
    }
}
