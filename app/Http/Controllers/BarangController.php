<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with('ruangan')->latest()->get();
        $ruangan = Ruangan::all();

        return view('barang.index', compact('barang', 'ruangan'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $request->validate([
            'nama_barang' => 'required',
            'ruangan_id' => 'required',
            'jumlah' => 'required|integer',
            'kondisi' => 'required',
            'keterangan' => 'nullable',
        ]);

        // Membuat kode barang otomatis
        $lastBarang = Barang::latest()->first();

        if ($lastBarang) {
            $nomor = (int) substr($lastBarang->kode_barang, 3) + 1;
        } else {
            $nomor = 1;
        }

        $kodeBarang = 'BRG' . str_pad($nomor, 3, '0', STR_PAD_LEFT);

        Barang::create([
            'kode_barang' => $kodeBarang,
            'nama_barang' => $request->nama_barang,
            'ruangan_id' => $request->ruangan_id,
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Data barang berhasil ditambahkan.');
    }

    public function update(Request $request, Barang $barang)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $request->validate([
            'nama_barang' => 'required',
            'ruangan_id' => 'required',
            'jumlah' => 'required|integer',
            'kondisi' => 'required',
            'keterangan' => 'nullable',
        ]);

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'ruangan_id' => $request->ruangan_id,
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Data barang berhasil diupdate.');
    }

    public function destroy(Barang $barang)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $barang->delete();

        return back()->with('success', 'Data barang berhasil dihapus.');
    }
}
