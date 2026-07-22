<x-app-layout>

<x-slot name="header">

<div>
    <h2 class="font-bold text-3xl text-gray-800">
        Dashboard Sarpras
    </h2>

    <p class="text-gray-500 mt-1">
        Sistem Informasi Sarana dan Prasarana Sekolah
    </p>
</div>

</x-slot>


<div class="py-8">

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


<!-- Welcome -->

<div class="bg-gradient-to-r from-blue-700 to-indigo-500 rounded-2xl shadow-xl p-8 text-white mb-8">

<h1 class="text-3xl font-bold">
    Selamat Datang, {{ Auth::user()->name }} 👋
</h1>

<p class="mt-3 text-blue-100">
    Kelola aset sekolah mulai dari barang,
    ruangan, peminjaman, hingga pengembalian.
</p>

</div>



<!-- Statistik -->

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">


<div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition">

<p class="text-gray-500">
🏫 Total Ruangan
</p>

<h3 class="text-4xl font-bold text-blue-600 mt-3">
{{ $totalRuangan }}
</h3>

</div>



<div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition">

<p class="text-gray-500">
📦 Total Barang
</p>

<h3 class="text-4xl font-bold text-green-600 mt-3">
{{ $totalBarang }}
</h3>

</div>



<div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition">

<p class="text-gray-500">
📝 Sedang Dipinjam
</p>

<h3 class="text-4xl font-bold text-yellow-500 mt-3">
{{ $totalDipinjam }}
</h3>

</div>



<div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition">

<p class="text-gray-500">
✅ Barang Baik
</p>

<h3 class="text-4xl font-bold text-emerald-500 mt-3">
{{ $barangBaik }}
</h3>

</div>



<div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition">

<p class="text-gray-500">
⚠️ Rusak Ringan
</p>

<h3 class="text-4xl font-bold text-orange-500 mt-3">
{{ $rusakRingan }}
</h3>

</div>



<div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition">

<p class="text-gray-500">
❌ Rusak Berat
</p>

<h3 class="text-4xl font-bold text-red-600 mt-3">
{{ $rusakBerat }}
</h3>

</div>

<div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition">

<p class="text-gray-500">
📦 Sedang Dipinjam
</p>

<h3 class="text-4xl font-bold text-purple-600 mt-3">
{{ $totalDipinjam }}
</h3>

</div>


</div>


<!-- Menu Cepat -->

<div class="mt-10">

    <h2 class="text-xl font-bold text-gray-800 mb-5">
        Menu Cepat
    </h2>


    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">


        <a href="{{ route('barang.index') }}"
           class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition">

            <h3 class="font-bold text-lg text-gray-800">
                📦 Barang
            </h3>

            <p class="text-gray-500 mt-2">
                Kelola data barang sekolah
            </p>

        </a>



        <a href="{{ route('ruangan.index') }}"
           class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition">

            <h3 class="font-bold text-lg text-gray-800">
                🏫 Ruangan
            </h3>

            <p class="text-gray-500 mt-2">
                Kelola data ruangan sekolah
            </p>

        </a>



        <a href="{{ route('peminjaman.index') }}"
           class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition">

            <h3 class="font-bold text-lg text-gray-800">
                📝 Peminjaman
            </h3>

            <p class="text-gray-500 mt-2">
                Data barang yang sedang dipinjam
            </p>

        </a>



        <a href="{{ route('pengembalian.index') }}"
           class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition">

            <h3 class="font-bold text-lg text-gray-800">
                ↩ Pengembalian
            </h3>

            <p class="text-gray-500 mt-2">
                Data barang yang sudah kembali
            </p>

        </a>


    </div>

</div>



<!-- Peminjaman Terbaru -->

<div class="mt-10">


<h2 class="text-xl font-bold text-gray-800 mb-5">
    Peminjaman Terbaru
</h2>



<div class="bg-white rounded-2xl shadow-md overflow-hidden">


<table class="min-w-full">


<thead class="bg-blue-600 text-white">

<tr>

<th class="px-6 py-3 text-left">
No
</th>

<th class="px-6 py-3 text-left">
Peminjam
</th>

<th class="px-6 py-3 text-left">
Barang
</th>

<th class="px-6 py-3 text-center">
Tanggal
</th>

<th class="px-6 py-3 text-center">
Status
</th>

</tr>

</thead>



<tbody>


@forelse($peminjamanTerbaru as $item)


<tr class="border-b hover:bg-gray-50">


<td class="px-6 py-4">
{{ $loop->iteration }}
</td>



<td class="px-6 py-4">
{{ $item->nama_peminjam }}
</td>



<td class="px-6 py-4">
{{ $item->barang->nama_barang }}
</td>



<td class="px-6 py-4 text-center">
{{ $item->tanggal_pinjam }}
</td>



<td class="px-6 py-4 text-center">


@if($item->status == 'Dipinjam')

<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">
Dipinjam
</span>


@else


<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
Dikembalikan
</span>


@endif


</td>


</tr>



@empty


<tr>

<td colspan="5" class="text-center py-6 text-gray-500">

Belum ada data peminjaman

</td>

</tr>


@endforelse


</tbody>


</table>


</div>


</div>



</div>

</div>

<!-- Grafik Kondisi Barang -->

<div class="mt-10 bg-white rounded-2xl shadow-md p-6">

    <h2 class="text-xl font-bold text-gray-800 mb-5">
        Grafik Kondisi Barang
    </h2>

    <div class="w-full md:w-1/2 mx-auto">

        <canvas id="kondisiChart"></canvas>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

const ctx = document.getElementById('kondisiChart');


new Chart(ctx, {

    type: 'doughnut',

    data: {

        labels: [
            'Barang Baik',
            'Rusak Ringan',
            'Rusak Berat'
        ],

        datasets: [{

            data: @json($grafikKondisi),

        }]

    },


    options: {

        responsive: true,

        plugins: {

            legend: {

                position: 'bottom'

            }

        }

    }

});

</script>

</x-app-layout>