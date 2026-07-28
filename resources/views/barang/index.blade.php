<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800">
                Data Barang
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

                ➕ Tambah Barang

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

            <div class="bg-white rounded-2xl shadow-xl p-4">

                <div id="barangGrid"></div>

                <form id="deleteForm" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>

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
                    method="POST"
                    enctype="multipart/form-data">
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
                            class="select2 w-full border rounded-lg px-4 py-2"
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
                            class="select2 w-full border rounded-lg px-4 py-2"
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

                    <div class="mb-4">

                        <label class="block mb-2 font-medium">
                            Foto Barang
                        </label>

                        <input
                            type="file"
                            name="foto"
                            accept="image/*"
                            class="w-full border rounded-lg px-4 py-2">

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
    bg-gradient-to-r from-emerald-500 to-green-600
    hover:from-emerald-600 hover:to-green-700
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
                    method="POST"
                    enctype="multipart/form-data">

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

                        <div class="mb-4">

                            <label class="block mb-2 font-medium">
                                Ganti Foto Barang
                            </label>

                            <input
                                type="file"
                                name="foto"
                                accept="image/*"
                                class="w-full border rounded-lg px-4 py-2">

                            <small class="text-gray-500">
                                Kosongkan jika tidak ingin mengganti foto.
                            </small>

                        </div>

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
            $.get("/barang/data", function(data) {

                $("#barangGrid").dxDataGrid({

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


                    sorting: {
                        mode: "multiple"
                    },

                    columnChooser: {
                        enabled: true
                    },

                    searchPanel: {
                        visible: true,
                        width: 300,
                        placeholder: "🔍 Cari data barang..."
                    },

                    filterRow: {
                        visible: true,
                        applyFilter: "auto"
                    },

                    headerFilter: {
                        visible: true
                    },

                    showBorders: true,
                    showColumnLines: false,
                    showRowLines: true,

                    paging: {
                        pageSize: 10
                    },

                    pager: {
                        showPageSizeSelector: true,
                        allowedPageSizes: [5, 10, 20, 50],
                        showNavigationButtons: true,
                        showInfo: true
                    },

                    export: {
                        enabled: true,
                        allowExportSelectedData: true,
                        fileName: "Data Barang"
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
                            dataField: "kode_barang",
                            caption: "Kode Barang",
                            width: 120
                        },
                        {
                            dataField: "foto",
                            caption: "Foto",
                            width: 100,
                            alignment: "center",

                            cellTemplate: function(container, options) {

                                if (options.value) {

                                    $("<img>")
                                        .attr("src", "/storage/" + options.value)
                                        .css({
                                            width: "60px",
                                            height: "60px",
                                            objectFit: "cover",
                                            borderRadius: "8px"
                                        })
                                        .appendTo(container);

                                } else {

                                    container.text("-");

                                }

                            }
                        },

                        {
                            dataField: "nama_barang",
                            caption: "Nama Barang",
                            minWidth: 200
                        },
                        {
                            dataField: "ruangan.nama_ruangan",
                            caption: "Ruangan",
                            width: 120
                        },
                        {
                            dataField: "jumlah",
                            caption: "Jumlah",
                            width: 90,
                            alignment: "center"
                        },
                        {
                            dataField: "kondisi",
                            caption: "Kondisi",

                            cellTemplate: function(container, options) {

                                let background = "";
                                let shadow = "";

                                if (options.value == "Baik") {
                                    background = "linear-gradient(135deg,#22c55e,#16a34a)";
                                    shadow = "0 8px 20px rgba(34,197,94,.40)";
                                }

                                if (options.value == "Rusak Ringan") {
                                    background = "linear-gradient(135deg,#fbbf24,#d97706)";
                                    shadow = "0 8px 20px rgba(251,191,36,.45)";
                                }

                                if (options.value == "Rusak Berat") {
                                    background = "linear-gradient(135deg,#ef4444,#b91c1c)";
                                    shadow = "0 8px 20px rgba(239,68,68,.45)";
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
                            caption: "Keterangan"
                        },
                        {
                            caption: "Aksi",
                            width: 180,
                            allowExporting: false,

                            cellTemplate: function(container, options) {

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
                                            options.data.nama_barang,
                                            options.data.ruangan_id,
                                            options.data.jumlah,
                                            options.data.kondisi,
                                            options.data.keterangan
                                        );

                                    })
                                    .appendTo(container)

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
                                        marginLeft: "8px",
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
                                            form.action = "/barang/" + options.data.id;
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

        <style>
            .dx-datagrid-headers {
                background: #2563eb;
                color: white;
                font-weight: bold;
            }

            .dx-header-row td {
                border: none !important;
            }

            .dx-datagrid-rowsview .dx-row-alt {
                background: #f8fafc;
            }

            .dx-data-row:hover {
                background: #dbeafe !important;
            }

            .dx-datagrid {
                border-radius: 14px;
                overflow: hidden;
            }

            <style>.dx-datagrid-headers {
                background: #f8fafc !important;
            }

            .dx-datagrid-headers .dx-datagrid-text-content {
                color: #1f2937 !important;
                font-weight: 700 !important;
                font-size: 14px !important;
            }
        </style>
        </style>

</x-app-layout>