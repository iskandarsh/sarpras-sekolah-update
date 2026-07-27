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

            <form method="GET" action="{{ route('barang.index') }}" class="mb-5">

                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama / kode barang..."
                        class="border rounded-lg px-4 py-2">

                    <select
                        name="ruangan_id"
                        class="border rounded-lg px-4 py-2">

                        <option value="">Semua Ruangan</option>

                        @foreach($ruangan as $r)

                        <option
                            value="{{ $r->id }}"
                            {{ request('ruangan_id') == $r->id ? 'selected' : '' }}>

                            {{ $r->nama_ruangan }}

                        </option>

                        @endforeach

                    </select>

                    <select
                        name="kondisi"
                        class="border rounded-lg px-4 py-2">

                        <option value="">Semua Kondisi</option>

                        <option value="Baik"
                            {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>
                            Baik
                        </option>

                        <option value="Rusak Ringan"
                            {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>
                            Rusak Ringan
                        </option>

                        <option value="Rusak Berat"
                            {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>
                            Rusak Berat
                        </option>

                    </select>

                    <div class="flex gap-2">

                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 rounded-lg">

                            Cari

                        </button>

                        <a
                            href="{{ route('barang.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

            <div class="bg-white rounded-xl shadow-lg">
                <div class="overflow-x-auto">

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
                $.get("/barang/data", function(data) {

                    $("#barangGrid").dxDataGrid({
                        dataSource: data,

                        keyExpr: "id",

                        showBorders: true,
                        showColumnLines: true,
                        showRowLines: true,
                        rowAlternationEnabled: true,
                        columnAutoWidth: true,
                        hoverStateEnabled: true,

                        sorting: {
                            mode: "multiple"
                        },

                        columnChooser: {
                            enabled: true
                        },

                        searchPanel: {
                            visible: true,
                            width: 250,
                            placeholder: "Cari barang..."
                        },

                        filterRow: {
                            visible: true
                        },

                        headerFilter: {
                            visible: true
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

                                    let warna = "#16a34a";

                                    if (options.value == "Rusak Ringan") {
                                        warna = "#ca8a04";
                                    }

                                    if (options.value == "Rusak Berat") {
                                        warna = "#dc2626";
                                    }

                                    $("<span>")
                                        .text(options.value)
                                        .css({
                                            background: warna,
                                            color: "white",
                                            padding: "5px 10px",
                                            borderRadius: "20px",
                                            fontSize: "12px"
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
                                        .text("Edit")
                                        .css({
                                            background: "#facc15",
                                            color: "white",
                                            border: "none",
                                            padding: "7px 14px",
                                            borderRadius: "8px",
                                            fontWeight: "bold",
                                            cursor: "pointer",
                                            marginRight: "8px"
                                        })
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
                                        .appendTo(container);

                                    $("<button>")
                                        .text("Hapus")
                                        .css({
                                            background: "#dc2626",
                                            color: "white",
                                            border: "none",
                                            padding: "7px 14px",
                                            borderRadius: "8px",
                                            fontWeight: "bold",
                                            cursor: "pointer"
                                        })
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

</x-app-layout>