<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800">
                Data Barang
            </h2>

            <button
                onclick="openTambahModal()"
                class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
                + Tambah Barang
            </button>
        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg">
                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead class="bg-blue-600 text-white">

                            <tr>

                                <th class="hidden md:table-cell px-3 md:px-6 py-3 text-left">
                                    No
                                </th>

                                <th class="hidden md:table-cell px-3 md:px-6 py-3 text-left">
                                    Kode Barang
                                </th>

                                <th class="px-6 py-3 text-left">Nama Barang</th>

                                <th class="px-6 py-3 text-left">Ruangan</th>

                                <th class="px-6 py-3 text-center">Jumlah</th>

                                <th class="px-6 py-3 text-center">Kondisi</th>

                                <th class="hidden md:table-cell px-3 md:px-6 py-3 text-left">
                                    Keterangan
                                </th>

                                <th class="px-6 py-3 text-center">Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($barang as $item)

                            <tr class="border-b hover:bg-gray-50">

                                <td class="hidden md:table-cell px-3 md:px-6 py-4">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="hidden md:table-cell px-3 md:px-6 py-4">
                                    {{ $item->kode_barang }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $item->nama_barang }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $item->ruangan->nama_ruangan }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $item->jumlah }}
                                </td>

                                <td class="px-6 py-4 text-center">

                                    @if($item->kondisi == 'Baik')

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                        Baik
                                    </span>

                                    @elseif($item->kondisi == 'Rusak Ringan')

                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">
                                        Rusak Ringan
                                    </span>

                                    @else

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">
                                        Rusak Berat
                                    </span>

                                    @endif

                                </td>

                                <td class="hidden md:table-cell px-3 md:px-6 py-4">
                                    {{ $item->keterangan }}
                                </td>

                                <td class="px-6 py-4">

                                    @if(Auth::user()->role == 'admin')

                                    <div class="flex flex-col md:flex-row justify-center gap-2">

                                        <button
                                            onclick="openEditModal(
        '{{ $item->id }}',
        '{{ $item->nama_barang }}',
        '{{ $item->ruangan_id }}',
        '{{ $item->jumlah }}',
        '{{ $item->kondisi }}',
        '{{ $item->keterangan }}'
    )"
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded">
                                            Edit
                                        </button>

                                        <form action="{{ route('barang.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                                                Hapus
                                            </button>
                                        </form>

                                    </div>

                                    @endif

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="8"
                                    class="text-center py-8 text-gray-500">

                                    Belum ada data barang.

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        {{-- PART 2 DIMULAI DI SINI --}}

        <!-- ===========================
        MODAL TAMBAH
============================ -->

        <div id="modalTambah"
            class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50 overflow-y-auto p-4">

            <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6">

                <div class="flex justify-between items-center mb-5">

                    <h2 class="text-xl font-bold">
                        Tambah Data Barang
                    </h2>

                    <button
                        onclick="closeTambahModal()"
                        class="text-2xl text-gray-500 hover:text-red-600">

                        &times;

                    </button>

                </div>

                <form
                    action="{{ route('barang.store') }}"
                    method="POST">

                    @csrf

                    <div class="mb-4">

                        <label class="block mb-2 font-medium">
                            Nama Barang
                        </label>

                        <input
                            type="text"
                            name="nama_barang"
                            class="w-full border rounded-lg px-4 py-2"
                            required>

                    </div>

                    <div class="mb-4">

                        <label class="block mb-2 font-medium">
                            Ruangan
                        </label>

                        <select
                            name="ruangan_id"
                            class="w-full border rounded-lg px-4 py-2"
                            required>

                            <option value="">
                                -- Pilih Ruangan --
                            </option>

                            @foreach($ruangan as $r)

                            <option value="{{ $r->id }}">
                                {{ $r->nama_ruangan }}
                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-4">

                        <label class="block mb-2 font-medium">
                            Jumlah
                        </label>

                        <input
                            type="number"
                            name="jumlah"
                            class="w-full border rounded-lg px-4 py-2"
                            required>

                    </div>

                    <div class="mb-4">

                        <label class="block mb-2 font-medium">
                            Kondisi
                        </label>

                        <select
                            name="kondisi"
                            class="w-full border rounded-lg px-4 py-2"
                            required>

                            <option value="Baik">
                                Baik
                            </option>

                            <option value="Rusak Ringan">
                                Rusak Ringan
                            </option>

                            <option value="Rusak Berat">
                                Rusak Berat
                            </option>

                        </select>

                    </div>

                    <div class="mb-4">

                        <label class="block mb-2 font-medium">
                            Keterangan
                        </label>

                        <textarea
                            name="keterangan"
                            rows="3"
                            class="w-full border rounded-lg px-4 py-2"></textarea>

                    </div>

                    <div class="flex justify-end gap-3">

                        <button
                            type="button"
                            onclick="closeTambahModal()"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

                            Batal

                        </button>

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

        <!-- ===========================
        MODAL EDIT
============================ -->

        <div id="modalEdit"
            class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50 overflow-y-auto p-4">

            <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 max-h-[90vh] overflow-y-auto my-8">


                <div class="flex justify-between items-center mb-5">

                    <h2 class="text-xl font-bold">
                        Edit Data Barang
                    </h2>

                    <button
                        onclick="closeEditModal()"
                        class="text-2xl text-gray-500 hover:text-red-600">

                        &times;

                    </button>

                </div>

                <form
                    id="formEdit"
                    method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">

                        <label class="block mb-2 font-medium">
                            Nama Barang
                        </label>

                        <input
                            type="text"
                            id="edit_nama_barang"
                            name="nama_barang"
                            class="w-full border rounded-lg px-4 py-2"
                            required>

                    </div>

                    <div class="mb-4">

                        <label class="block mb-2 font-medium">
                            Ruangan
                        </label>

                        <select
                            id="edit_ruangan"
                            name="ruangan_id"
                            class="w-full border rounded-lg px-4 py-2"
                            required>

                            @foreach($ruangan as $r)

                            <option value="{{ $r->id }}">
                                {{ $r->nama_ruangan }}
                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-4">

                        <label class="block mb-2 font-medium">
                            Jumlah
                        </label>

                        <input
                            type="number"
                            id="edit_jumlah"
                            name="jumlah"
                            class="w-full border rounded-lg px-4 py-2"
                            required>

                    </div>

                    <div class="mb-4">

                        <label class="block mb-2 font-medium">
                            Kondisi
                        </label>

                        <select
                            id="edit_kondisi"
                            name="kondisi"
                            class="w-full border rounded-lg px-4 py-2">

                            <option value="Baik">Baik</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">Rusak Berat</option>

                        </select>

                    </div>

                    <div class="mb-4">

                        <label class="block mb-2 font-medium">
                            Keterangan
                        </label>

                        <textarea
                            id="edit_keterangan"
                            name="keterangan"
                            rows="3"
                            class="w-full border rounded-lg px-4 py-2"></textarea>

                    </div>

                    <div class="flex justify-end gap-3">

                        <button
                            type="button"
                            onclick="closeEditModal()"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

                            Batal

                        </button>

                        <button
                            type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg">

                            Update

                        </button>

                    </div>

                </form>

            </div>

        </div>

        <script>
            function openTambahModal() {

                const modal = document.getElementById('modalTambah');

                modal.classList.remove('hidden');
                modal.classList.add('flex');

            }

            function closeTambahModal() {

                const modal = document.getElementById('modalTambah');

                modal.classList.remove('flex');
                modal.classList.add('hidden');

            }

            function openEditModal(id, nama_barang, ruangan_id, jumlah, kondisi, keterangan) {

                document.getElementById('edit_nama_barang').value = nama_barang;
                document.getElementById('edit_ruangan').value = ruangan_id;
                document.getElementById('edit_jumlah').value = jumlah;
                document.getElementById('edit_kondisi').value = kondisi;
                document.getElementById('edit_keterangan').value = keterangan;

                document.getElementById('formEdit').action = "/barang/" + id;

                const modal = document.getElementById('modalEdit');

                modal.classList.remove('hidden');
                modal.classList.add('flex');

            }

            function closeEditModal() {

                const modal = document.getElementById('modalEdit');

                modal.classList.remove('flex');
                modal.classList.add('hidden');

            }

            // Menutup modal jika klik area hitam
            window.onclick = function(event) {

                const modalTambah = document.getElementById('modalTambah');
                const modalEdit = document.getElementById('modalEdit');

                if (event.target == modalTambah) {

                    closeTambahModal();

                }

                if (event.target == modalEdit) {

                    closeEditModal();

                }

            }
        </script>

</x-app-layout>