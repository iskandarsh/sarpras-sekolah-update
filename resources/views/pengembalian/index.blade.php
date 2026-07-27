<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

            <h2 class="font-bold text-2xl text-gray-800">
                Data Pengembalian
            </h2>

            <button
                onclick="openTambahModal()"
                class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">

                + Tambah Pengembalian

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

            <form method="GET" action="{{ route('pengembalian.index') }}" class="mb-5">

                <div class="flex flex-col md:flex-row gap-3">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama peminjam..."
                        class="flex-1 border rounded-lg px-4 py-2">

                    <div class="flex gap-2">

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                            Cari
                        </button>

                        <a
                            href="{{ route('pengembalian.index') }}"
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

                            <div id="pengembalianGrid"></div>

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
                    Tambah Pengembalian
                </h2>


                <form action="{{ route('pengembalian.store') }}" method="POST">

                    @csrf


                    <div class="mb-4">

                        <label class="block mb-2">
                            Peminjaman
                        </label>


                        <select
                            name="peminjaman_id"
                            class="select2 w-full border rounded-lg px-4 py-2"
                            required>


                            <option value="">
                                -- Pilih Peminjaman --
                            </option>


                            @foreach($peminjaman as $p)

                            <option value="{{ $p->id }}">

                                {{ $p->nama_peminjam }}
                                -
                                {{ $p->barang->nama_barang }}

                            </option>

                            @endforeach


                        </select>

                    </div>



                    <div class="mb-4">

                        <label class="block mb-2">
                            Tanggal Pengembalian
                        </label>


                        <input
                            type="date"
                            name="tanggal_pengembalian"
                            class="w-full border rounded-lg px-4 py-2"
                            required>

                    </div>



                    <div class="mb-4">

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
                    Edit Pengembalian
                </h2>



                <form id="editForm" method="POST">


                    @csrf
                    @method('PUT')



                    <div class="mb-4">


                        <label class="block mb-2">
                            Tanggal Pengembalian
                        </label>


                        <input
                            id="edit_tanggal_pengembalian"
                            type="date"
                            name="tanggal_pengembalian"
                            class="w-full border rounded-lg px-4 py-2"
                            required>


                    </div>



                    <div class="mb-4">


                        <label class="block mb-2">
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
                            class="bg-blue-600 text-white px-5 py-2 rounded-lg">

                            Update

                        </button>


                    </div>



                </form>


            </div>


        </div>



        <script>
            $.get("/pengembalian/data", function(data) {

                $("#pengembalianGrid").dxDataGrid({

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
                        placeholder: "Cari pengembalian..."
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
                        fileName: "Data Pengembalian"
                    },

                    columnChooser: {
                        enabled: true
                    },

                    columns: [

                        {
                            caption: "No",
                            width: 60,
                            alignment: "center",
                            cellTemplate: function(container, options) {
                                container.text(options.rowIndex + 1);
                            }
                        },

                        {
                            dataField: "peminjaman.barang.nama_barang",
                            caption: "Barang"
                        },

                        {
                            dataField: "peminjaman.nama_peminjam",
                            caption: "Peminjam"
                        },

                        {
                            dataField: "tanggal_pengembalian",
                            caption: "Tanggal Pengembalian"
                        },

                        {
                            dataField: "keterangan",
                            caption: "Keterangan"
                        },

                        {
                            caption: "Aksi",
                            width: 220,
                            alignment: "center",
                            cellTemplate: function(container, options) {

                                $("<button>")
                                    .text("Edit")
                                    .css({
                                        background: "#facc15",
                                        color: "white",
                                        border: "none",
                                        padding: "6px 12px",
                                        borderRadius: "6px",
                                        cursor: "pointer",
                                        marginRight: "8px"
                                    })
                                    .on("click", function() {

                                        openEditModal(
                                            options.data.id,
                                            options.data.tanggal_pengembalian,
                                            options.data.keterangan
                                        );

                                    })
                                    .appendTo(container);

                                $("<button>")
                                    .text("Hapus")
                                    .css({
                                        background: "#dc2626",
                                        color: "white",
                                        border: "none",
                                        padding: "6px 12px",
                                        borderRadius: "6px",
                                        cursor: "pointer"
                                    })
                                    .on("click", function() {

                                        if (confirm("Yakin ingin menghapus data ini?")) {

                                            $("#deleteForm")
                                                .attr("action", "/pengembalian/" + options.data.id)
                                                .submit();

                                        }

                                    })
                                    .appendTo(container);

                            }
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

                document.getElementById('tambahModal')
                    .classList.remove('hidden');

                document.getElementById('tambahModal')
                    .classList.add('flex');

            }

            function closeTambahModal() {

                document.getElementById('tambahModal')
                    .classList.add('hidden');

                document.getElementById('tambahModal')
                    .classList.remove('flex');

            }

            function openEditModal(id, tanggal, keterangan) {

                document.getElementById('editModal')
                    .classList.remove('hidden');

                document.getElementById('editModal')
                    .classList.add('flex');

                document.getElementById('editForm').action =
                    '/pengembalian/' + id;

                document.getElementById('edit_tanggal_pengembalian').value =
                    tanggal;

                document.getElementById('edit_keterangan').value =
                    keterangan ?? '';

            }

            function closeEditModal() {

                document.getElementById('editModal')
                    .classList.add('hidden');

                document.getElementById('editModal')
                    .classList.remove('flex');

            }
        </script>


</x-app-layout>