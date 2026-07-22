<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Ruangan;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRuangan = Ruangan::count();

        $totalBarang = Barang::count();

        $barangBaik = Barang::where('kondisi', 'Baik')->count();

        $rusakRingan = Barang::where('kondisi', 'Rusak Ringan')->count();

        $rusakBerat = Barang::where('kondisi', 'Rusak Berat')->count();


        // Barang yang sedang dipinjam
        $totalDipinjam = Peminjaman::where('status', 'Dipinjam')->count();


        // Data peminjaman terbaru
        $peminjamanTerbaru = Peminjaman::with('barang')
            ->latest()
            ->take(5)
            ->get();


        // Data untuk grafik kondisi barang
        $grafikKondisi = [
            $barangBaik,
            $rusakRingan,
            $rusakBerat
        ];


        return view('dashboard', compact(
            'totalRuangan',
            'totalBarang',
            'barangBaik',
            'rusakRingan',
            'rusakBerat',
            'totalDipinjam',
            'peminjamanTerbaru',
            'grafikKondisi'
        ));
    }
}
