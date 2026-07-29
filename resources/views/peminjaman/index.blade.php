<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800">
                Data Peminjaman
            </h2>

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

                ➕ Tambah Peminjaman

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
    transition-all duration-300
    hover:-translate-y-1">

                        Batal

                    </button>

                    <button
                        type="submit"
                        class="
    bg-gradient-to-r from-blue-600 to-cyan-500
    hover:from-blue-700 hover:to-cyan-600
    text-white
    px-5 py-2
    rounded-xl
    shadow-lg
    transition-all duration-300
    hover:-translate-y-1">

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
    transition-all duration-300
    hover:-translate-y-1">

                        Batal

                    </button>

                    <button
                        type="submit"
                        class="
    bg-gradient-to-r from-blue-600 to-cyan-500
    hover:from-blue-700 hover:to-cyan-600
    text-white
    px-5 py-2
    rounded-xl
    shadow-lg
    transition-all duration-300
    hover:-translate-y-1">

                        Simpan

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
                showColumnLines: false,
                showRowLines: true,
                rowAlternationEnabled: true,
                hoverStateEnabled: true,
                columnAutoWidth: true,
                columnHidingEnabled: false,
                allowColumnResizing: true,
                columnResizingMode: "widget",

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

                columns: [

                    {
                        caption: "No",
                        width: 50,
                        alignment: "center",
                        cellTemplate: function(container, options) {
                            container.text(options.rowIndex + 1);
                        }
                    },

                    {
                        dataField: "barang.kode_barang",
                        caption: "Kode",
                        width: 80
                    },

                    {
                        dataField: "barang.nama_barang",
                        caption: "Nama Barang",
                        minWidth: 170
                    },

                    {
                        dataField: "nama_peminjam",
                        caption: "Peminjam",
                        minWidth: 140
                    },

                    {
                        dataField: "jumlah",
                        caption: "Jumlah",
                        width: 70,
                        alignment: "center"
                    },

                    {
                        dataField: "tanggal_pinjam",
                        caption: "Tanggal Pinjam",
                        width: 110,
                        alignment: "center"
                    },

                    {
                        dataField: "status",
                        caption: "Status",
                        width: 140,
                        alignment: "center",

                        cellTemplate: function(container, options) {

                            let background = "";
                            let shadow = "";

                            if (options.value == "Dipinjam") {

                                background = "linear-gradient(135deg,#2563EB,#3B82F6)";
                                shadow = "0 6px 15px rgba(37,99,235,.35)";

                            } else {

                                background = "linear-gradient(135deg,#16A34A,#22C55E)";
                                shadow = "0 6px 15px rgba(34,197,94,.35)";

                            }

                            $("<span>")
                                .text(options.value)
                                .css({
                                    background: background,
                                    color: "#fff",
                                    padding: "8px 16px",
                                    borderRadius: "999px",
                                    fontSize: "13px",
                                    fontWeight: "700",
                                    display: "inline-block",
                                    boxShadow: shadow,
                                    letterSpacing: ".3px"
                                })
                                .appendTo(container);

                        }

                    },

                    {
                        dataField: "keterangan",
                        caption: "Keterangan",
                        minWidth: 110
                    },

                    {
                        caption: "Aksi",
                        width: 180,
                        minWidth: 180,
                        fixed: true,
                        fixedPosition: "right",
                        allowHiding: false,
                        allowExporting: false,

                        cellTemplate: function(container, options) {

                            $("<button>")
                                .html("<i class='fa-solid fa-pen'></i> Edit")
                                .css({
                                    background: "linear-gradient(135deg,#2563EB,#3B82F6)",
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
                                        options.data.nama_peminjam,
                                        options.data.barang_id,
                                        options.data.jumlah,
                                        options.data.tanggal_pinjam,
                                        options.data.tanggal_kembali,
                                        options.data.status,
                                        options.data.keterangan
                                    );

                                })
                                .appendTo(container);

                            $("<button>")
                                .html("<i class='fa-solid fa-trash'></i> Hapus")
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
                                        form.action = "/peminjaman/" + options.data.id;
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

    <style>
        .dx-datagrid-headers {
            font-weight: 700;
            font-size: 14px;
        }

        .dx-datagrid-headers .dx-header-row>td {
            font-weight: 700 !important;
            color: #111827;
            background-color: #f8fafc;
        }
    </style>

</x-app-layout>