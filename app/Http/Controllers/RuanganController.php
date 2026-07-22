<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::latest()->get();

        return view('ruangan.index', compact('ruangan'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $request->validate([
            'nama_ruangan' => 'required',
            'lantai' => 'required',
            'keterangan' => 'nullable'
        ]);

        Ruangan::create($request->all());

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $request->validate([
            'nama_ruangan' => 'required',
            'lantai' => 'required',
            'keterangan' => 'nullable'
        ]);

        $ruangan->update($request->all());

        return back()->with('success', 'Data berhasil diubah');
    }

    public function destroy(Ruangan $ruangan)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $ruangan->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
