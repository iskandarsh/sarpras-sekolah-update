<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Ruangan::query();

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_ruangan', 'like', '%' . $request->search . '%')
                    ->orWhere('lantai', 'like', '%' . $request->search . '%');
            });
        }

        $ruangan = $query->latest()->get();

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

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Menambahkan ruangan "' . $request->nama_ruangan . '"',
        ]);

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

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Mengubah ruangan "' . $ruangan->nama_ruangan . '"',
        ]);

        return back()->with('success', 'Data berhasil diubah');
    }

    public function destroy(Ruangan $ruangan)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $ruangan->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Menghapus ruangan "' . $ruangan->nama_ruangan . '"',
        ]);

        return back()->with('success', 'Data berhasil dihapus');
    }
}
