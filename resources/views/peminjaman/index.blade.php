<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800">
                Data Peminjaman
            </h2>

            <button
                onclick="openTambahModal()"
                class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
                + Tambah Peminjaman
            </button>
        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-5">
                {{ session('success') }}
            </div>
            @endif

            <form method="GET" action="{{ route('peminjaman.index') }}" class="mb-5">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama peminjam..."
                        class="border rounded-lg px-4 py-2">

                    <select
                        name="status"
                        class="border rounded-lg px-4 py-2">

                        <option value="">Semua Status</option>

                        <option value="Dipinjam"
                            {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>
                            Dipinjam
                        </option>

                        <option value="Dikembalikan"
                            {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>
                            Dikembalikan
                        </option>

                    </select>

                    <div class="flex gap-2">

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                            Cari

                        </button>

                        <a
                            href="{{ route('peminjaman.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

            <div class="bg-white rounded-xl shadow-lg">
                <div class="overflow-x-auto">

                    <div class="bg-white rounded-xl shadow-lg">
                        <div class="overflow-x-auto">

                            <div id="peminjamanGrid"></div>

                            <form id="deleteForm" method="POST" style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>

                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Modal Tambah -->
        <div id="tambahModal"
            class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 overflow-y-auto p-4">

            <div class="bg-white rounded-xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto my-8">

                <h2 class="text-xl font-bold mb-5">
                    Tambah Peminjaman
                </h2>

                <form action="{{ route('peminjaman.store') }}" method="POST">

                    @csrf

                    <div class="mb-4">
                        <label class="block mb-2">Nama Peminjam</label>

                        <input
                            type="text"
                            name="nama_peminjam"
                            class="w-full border rounded-lg px-4 py-2"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Barang</label>

                        <select
                            name="barang_id"
                            class="select2 w-full border rounded-lg px-4 py-2"
                            required>

                            <option value="">-- Pilih Barang --</option>

                            @foreach($barang as $b)

                            <option value="{{ $b->id }}">
                                {{ $b->nama_barang }}
                            </option>

                            @endforeach

                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <label class="block mb-2">
                                Jumlah
                            </label>

                            <input
                                type="number"
                                name="jumlah"
                                class="w-full border rounded-lg px-4 py-2"
                                required>
                        </div>

                        <div>
                            <label class="block mb-2">
                                Status
                            </label>

                            <select
                                name="status"
                                class="select2 w-full border rounded-lg px-4 py-2">

                                <option value="Dipinjam">
                                    Dipinjam
                                </option>

                                <option value="Dikembalikan">
                                    Dikembalikan
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">

                        <div>
                            <label class="block mb-2">
                                Tanggal Pinjam
                            </label>

                            <input
                                type="date"
                                name="tanggal_pinjam"
                                class="w-full border rounded-lg px-4 py-2"
                                required>
                        </div>

                        <div>
                            <label class="block mb-2">
                                Tanggal Kembali
                            </label>

                            <input
                                type="date"
                                name="tanggal_kembali"
                                class="w-full border rounded-lg px-4 py-2">
                        </div>

                    </div>

                    <div class="mt-4">

                        <label class="block mb-2">
                            Keterangan
                        </label>

                        <textarea
                            name="keterangan"
                            rows="3"
                            class="w-full border rounded-lg px-4 py-2"></textarea>

                    </div>

                    <div class="flex justify-end gap-3 mt-6">

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
        <div id="editModal"
            class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50 overflow-y-auto p-4">

            <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 max-h-[90vh] overflow-y-auto my-8">


                <h2 class="text-xl font-bold mb-5">
                    Edit Peminjaman
                </h2>

                <form id="editForm" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-2">Nama Peminjam</label>

                        <input
                            id="edit_nama_peminjam"
                            type="text"
                            name="nama_peminjam"
                            class="w-full border rounded-lg px-4 py-2"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Barang</label>

                        <select
                            id="edit_barang_id"
                            name="barang_id"
                            class="w-full border rounded-lg px-4 py-2"
                            required>

                            @foreach($barang as $b)
                            <option value="{{ $b->id }}">
                                {{ $b->nama_barang }}
                            </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Jumlah</label>

                        <input
                            id="edit_jumlah"
                            type="number"
                            name="jumlah"
                            class="w-full border rounded-lg px-4 py-2"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Status</label>

                        <select
                            id="edit_status"
                            name="status"
                            class="w-full border rounded-lg px-4 py-2"
                            required>

                            <option value="Dipinjam">Dipinjam</option>
                            <option value="Dikembalikan">Dikembalikan</option>

                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">

                        <div>
                            <label class="block mb-2">
                                Tanggal Pinjam
                            </label>

                            <input
                                id="edit_tanggal_pinjam"
                                type="date"
                                name="tanggal_pinjam"
                                class="w-full border rounded-lg px-4 py-2"
                                required>
                        </div>

                        <div>
                            <label class="block mb-2">
                                Tanggal Kembali
                            </label>

                            <input
                                id="edit_tanggal_kembali"
                                type="date"
                                name="tanggal_kembali"
                                class="w-full border rounded-lg px-4 py-2">
                        </div>

                    </div>

                    <div class="mt-4">

                        <label class="block mb-2">
                            Keterangan
                        </label>

                        <textarea
                            id="edit_keterangan"
                            name="keterangan"
                            rows="3"
                            class="w-full border rounded-lg px-4 py-2"></textarea>

                    </div>

                    <div class="flex justify-end gap-3 mt-6">

                        <button
                            type="button"
                            onclick="closeEditModal()"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                            Update
                        </button>

                    </div>

                </form>

            </div>

        </div>

        <script>
            $.get("/peminjaman/data", function(data) {

                $("#peminjamanGrid").dxDataGrid({

                    dataSource: data,

                    keyExpr: "id",

                    showBorders: true,
                    showColumnLines: true,
                    showRowLines: true,
                    rowAlternationEnabled: true,
                    columnAutoWidth: true,
                    hoverStateEnabled: true,

                    searchPanel: {
                        visible: true,
                        width: 250,
                        placeholder: "Cari peminjaman..."
                    },

                    filterRow: {
                        visible: true
                    },

                    headerFilter: {
                        visible: true
                    },

                    sorting: {
                        mode: "multiple"
                    },

                    paging: {
                        pageSize: 10
                    },

                    pager: {
                        showPageSizeSelector: true,
                        allowedPageSizes: [5, 10, 20, 50],
                        showInfo: true
                    },

                    export: {
                        enabled: true,
                        allowExportSelectedData: true,
                        fileName: "Data Peminjaman"
                    },

                    columnChooser: {
                        enabled: true
                    },

                    columns: [{
                            caption: "No",
                            width: 60,
                            alignment: "center",
                            cellTemplate: function(container, options) {
                                container.text(options.rowIndex + 1);
                            }
                        },

                        {
                            dataField: "barang.nama_barang",
                            caption: "Barang"
                        },

                        {
                            dataField: "nama_peminjam",
                            caption: "Peminjam"
                        },

                        {
                            dataField: "jumlah",
                            caption: "Jumlah",
                            alignment: "center"
                        },

                        {
                            dataField: "tanggal_pinjam",
                            caption: "Tanggal Pinjam"
                        },

                        {
                            dataField: "tanggal_kembali",
                            caption: "Tanggal Kembali"
                        },

                        {
                            dataField: "status",
                            caption: "Status"
                        }
                    ]

                });

            });
            $(document).ready(function() {
                $('.select2').select2({
                    width: '100%'
                });
            });

            function openTambahModal() {
                document.getElementById('tambahModal').classList.remove('hidden');
                document.getElementById('tambahModal').classList.add('flex');
            }

            function closeTambahModal() {
                document.getElementById('tambahModal').classList.add('hidden');
                document.getElementById('tambahModal').classList.remove('flex');
            }

            function openEditModal(id, nama, barang, jumlah, tanggal, kembali, status, keterangan) {

                document.getElementById('editModal').classList.remove('hidden');
                document.getElementById('editModal').classList.add('flex');

                document.getElementById('editForm').action = '/peminjaman/' + id;

                document.getElementById('edit_nama_peminjam').value = nama;
                document.getElementById('edit_barang_id').value = barang;
                document.getElementById('edit_jumlah').value = jumlah;
                document.getElementById('edit_status').value = status;
                document.getElementById('edit_tanggal_pinjam').value = tanggal;
                document.getElementById('edit_tanggal_kembali').value = kembali ?? '';
                document.getElementById('edit_keterangan').value = keterangan ?? '';
            }

            function closeEditModal() {
                document.getElementById('editModal').classList.add('hidden');
                document.getElementById('editModal').classList.remove('flex');
            }
        </script>

</x-app-layout>