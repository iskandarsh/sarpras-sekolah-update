<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-5">
            <h2 class="font-bold text-2xl text-gray-800">
                Data Ruangan
            </h2>

            @if(Auth::user()->role == 'admin')
            <button
                onclick="openTambahModal()"
                class="
        bg-gradient-to-r from-violet-600 to-purple-600
        hover:from-violet-700 hover:to-purple-700
        text-white
        px-6 py-3
        rounded-xl
        shadow-lg
        hover:shadow-purple-500/40
        transition-all
        duration-300
        hover:-translate-y-1">

                ➕ Tambah Ruangan

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

            <div class="bg-white rounded-2xl shadow-xl p-4">

                <div id="ruanganGrid"></div>

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
                        class="
bg-gradient-to-r from-gray-500 to-slate-700
hover:from-gray-600 hover:to-slate-800
text-white
px-5 py-2
rounded-xl
shadow-lg
transition-all
duration-300
hover:-translate-y-1">

                        Batal

                    </button>

                    <button
                        type="submit"
                        class="
bg-gradient-to-r from-emerald-500 to-green-600
hover:from-emerald-600 hover:to-green-700
text-white
px-5 py-2
rounded-xl
shadow-lg
hover:shadow-green-400/40
transition-all
duration-300
hover:-translate-y-1">

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

                <form id="editForm" method="POST">

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
                            class="
bg-gradient-to-r from-gray-500 to-slate-700
hover:from-gray-600 hover:to-slate-800
text-white
px-5 py-2
rounded-xl
shadow-lg
transition-all
duration-300
hover:-translate-y-1">

                            Batal

                        </button>

                        <button
                            type="submit"
                            class="
bg-gradient-to-r from-blue-600 to-sky-500
hover:from-blue-700 hover:to-sky-600
text-white
px-5 py-2
rounded-xl
shadow-lg
hover:shadow-blue-400/40
transition-all
duration-300
hover:-translate-y-1">

                            Update

                        </button>

                    </div>

                </form>

            </div>

        </div>

        <script>
            $.get("/ruangan/data", function(data) {

                $("#ruanganGrid").dxDataGrid({

                    dataSource: data,

                    keyExpr: "id",

                    showBorders: true,
                    showColumnLines: false,
                    showRowLines: true,
                    rowAlternationEnabled: true,
                    hoverStateEnabled: true,
                    columnAutoWidth: true,
                    columnHidingEnabled: true,
                    allowColumnResizing: true,
                    columnResizingMode: "widget",

                    searchPanel: {
                        visible: true,
                        width: 250,
                        placeholder: "Cari data ruangan..."
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
                        fileName: "Data Ruangan"
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
                            dataField: "nama_ruangan",
                            caption: "Nama Ruangan"
                        },

                        {
                            dataField: "gedung",
                            caption: "Gedung"
                        },

                        {
                            dataField: "lantai",
                            caption: "Lantai"
                        },

                        {
                            dataField: "keterangan",
                            caption: "Keterangan"
                        },

                        // taruh Aksi di sini paling bawah
                        {
                            caption: "Aksi",
                            width: 180,
                            allowExporting: false,

                            cellTemplate: function(container, options) {

                                // Tombol Edit
                                $("<button>")
                                    .html("<i class='fa-solid fa-pen'></i> Edit")
                                    .css({
                                        background: "linear-gradient(to right, #2563EB, #0EA5E9)",
                                        color: "#fff",
                                        border: "none",
                                        padding: "10px 18px",
                                        borderRadius: "12px",
                                        fontWeight: "600",
                                        cursor: "pointer",
                                        marginRight: "8px",
                                        boxShadow: "0 8px 20px rgba(37,99,235,.40)",
                                        transition: "all .3s"
                                    })
                                    .hover(
                                        function() {
                                            $(this).css({
                                                transform: "translateY(-3px)",
                                                boxShadow: "0 12px 25px rgba(37,99,235,.55)"
                                            });
                                        },
                                        function() {
                                            $(this).css({
                                                transform: "translateY(0)",
                                                boxShadow: "0 8px 20px rgba(37,99,235,.40)"
                                            });
                                        }
                                    )
                                    .on("click", function() {

                                        openEditModal(
                                            options.data.id,
                                            options.data.nama_ruangan,
                                            options.data.lantai,
                                            options.data.keterangan
                                        );

                                    })
                                    .appendTo(container);

                                // Tombol Hapus
                                $("<button>")
                                    .html("🗑️ Hapus")
                                    .css({
                                        background: "linear-gradient(135deg,#EF4444,#DC2626)",
                                        color: "#fff",
                                        border: "none",
                                        padding: "10px 18px",
                                        borderRadius: "12px",
                                        fontWeight: "600",
                                        cursor: "pointer",
                                        boxShadow: "0 8px 20px rgba(239,68,68,.40)",
                                        transition: "all .3s"
                                    })
                                    .hover(
                                        function() {
                                            $(this).css({
                                                transform: "translateY(-3px)",
                                                boxShadow: "0 12px 25px rgba(239,68,68,.55)"
                                            });
                                        },
                                        function() {
                                            $(this).css({
                                                transform: "translateY(0)",
                                                boxShadow: "0 8px 20px rgba(239,68,68,.40)"
                                            });
                                        }
                                    )
                                    .on("click", function() {

                                        if (confirm("Yakin ingin menghapus data ini?")) {

                                            const form = document.getElementById("deleteForm");
                                            form.action = "/ruangan/" + options.data.id;
                                            form.submit();

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

                document.getElementById('modalTambah')
                    .classList.remove('hidden');

                document.getElementById('modalTambah')
                    .classList.add('flex');

            }


            function closeTambahModal() {

                document.getElementById('modalTambah')
                    .classList.add('hidden');

                document.getElementById('modalTambah')
                    .classList.remove('flex');

            }


            function openEditModal(id, nama_ruangan, lantai, keterangan) {

                document.getElementById('modalEdit').classList.remove('hidden');
                document.getElementById('modalEdit').classList.add('flex');

                document.getElementById('editForm').action = "/ruangan/" + id;

                document.getElementById('edit_nama_ruangan').value = nama_ruangan;
                document.getElementById('edit_lantai').value = lantai;
                document.getElementById('edit_keterangan').value = keterangan ?? '';
            }

            function closeEditModal() {

                document.getElementById('modalEdit').classList.add('hidden');
                document.getElementById('modalEdit').classList.remove('flex');

            }


            function closeEditModal() {

                document.getElementById('modalEdit')
                    .classList.add('hidden');

                document.getElementById('modalEdit')
                    .classList.remove('flex');

            }
        </script>

</x-app-layout>