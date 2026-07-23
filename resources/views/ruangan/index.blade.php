<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-5">
            <h2 class="font-bold text-2xl text-gray-800">
                Data Ruangan
            </h2>

            @if(Auth::user()->role == 'admin')
            <button
                onclick="openTambahModal()"
                class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
                + Tambah Ruangan
            </button>
            @endif
        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
            @endif

            <form method="GET" action="{{ route('ruangan.index') }}" class="mb-5">

                <div class="flex flex-col md:flex-row gap-3">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama ruangan atau lantai..."
                        class="flex-1 border rounded-lg px-4 py-2">

                    <div class="flex gap-2">

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                            Cari

                        </button>

                        <a
                            href="{{ route('ruangan.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

            <div class="bg-white rounded-xl shadow-lg">
                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead class="bg-blue-600 text-white">

                            <tr>

                                <th class="hidden md:table-cell px-3 md:px-6 py-3 text-left">
                                    No
                                </th>

                                <th class="px-6 py-3 text-left">Nama Ruangan</th>

                                <th class="px-6 py-3 text-left">Lantai</th>

                                <th class="hidden md:table-cell px-3 md:px-6 py-3 text-left">
                                    Keterangan
                                </th>

                                <th class="px-6 py-3 text-center">Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($ruangan as $item)

                            <tr class="border-b hover:bg-gray-50">

                                <td class="hidden md:table-cell px-3 md:px-6 py-4">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $item->nama_ruangan }}
                                </td>


                                <td class="px-6 py-4">
                                    {{ $item->lantai }}
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
        '{{ $item->nama_ruangan }}',
        '{{ $item->lantai }}',
        '{{ $item->keterangan }}'
        )"
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded">
                                            Edit
                                        </button>

                                        <form action="{{ route('ruangan.destroy', $item->id) }}" method="POST">
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

                                <td colspan="6"
                                    class="text-center py-8 text-gray-500">

                                    Belum ada data ruangan.

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- Modal Tambah -->
        <<div id="modalTambah"
            class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 overflow-y-auto p-4">

            <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 max-h-[90vh] overflow-y-auto my-8">

                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-xl font-bold">Tambah Data Ruangan</h2>

                    <button onclick="closeTambahModal()"
                        class="text-gray-500 hover:text-red-600 text-2xl">
                        &times;
                    </button>
                </div>

                <form action="{{ route('ruangan.store') }}" method="POST">

                    @csrf

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Nama Ruangan
                        </label>

                        <input
                            type="text"
                            name="nama_ruangan"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>


                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Lantai
                        </label>

                        <input
                            type="text"
                            name="lantai"
                            class="w-full border rounded-lg px-4 py-2"
                            required>
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
    <!-- Modal Edit -->
    <div id="modalEdit"
        class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50 overflow-y-auto p-4">

        <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 max-h-[90vh] overflow-y-auto my-8">

            <div class="flex justify-between items-center mb-5">
                <h2 class="text-xl font-bold">
                    Edit Data Ruangan
                </h2>

                <button onclick="closeEditModal()" class="text-2xl text-gray-500 hover:text-red-600">
                    &times;
                </button>
            </div>

            <form id="formEdit" method="POST">

                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block mb-2 font-medium">
                        Nama Ruangan
                    </label>

                    <input
                        type="text"
                        id="edit_nama_ruangan"
                        name="nama_ruangan"
                        class="w-full border rounded-lg px-4 py-2"
                        required>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 font-medium">
                        Lantai
                    </label>

                    <input
                        type="text"
                        id="edit_lantai"
                        name="lantai"
                        class="w-full border rounded-lg px-4 py-2"
                        required>
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
                        class="bg-gray-500 text-white px-5 py-2 rounded-lg">

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

        function openEditModal(id, nama_ruangan, lantai, keterangan) {

            document.getElementById('edit_nama_ruangan').value = nama_ruangan;
            document.getElementById('edit_lantai').value = lantai;
            document.getElementById('edit_keterangan').value = keterangan;

            document.getElementById('formEdit').action = "/ruangan/" + id;

            document.getElementById('modalEdit').classList.remove('hidden');
            document.getElementById('modalEdit').classList.add('flex');
        }

        function closeEditModal() {

            document.getElementById('modalEdit').classList.remove('flex');
            document.getElementById('modalEdit').classList.add('hidden');
        }
    </script>

</x-app-layout>