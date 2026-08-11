<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

            <h2 class="font-bold text-2xl text-gray-800">
                Data User
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

                ➕ Tambah User

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

                    <div id="userGrid"></div>

                    <form id="deleteForm" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>

                </div>

            </div>

        </div>

        <!-- Modal Tambah -->
        <div id="tambahModal"
            class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 overflow-y-auto p-4">

            <div class="bg-white rounded-xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto my-8">

                <h2 class="text-xl font-bold mb-5">
                    Tambah User
                </h2>

                @csrf

                <div class="mb-4">
                    <label class="block mb-2">Nama</label>

                    <input
                        type="text"
                        name="name"
                        class="w-full border rounded-lg px-4 py-2"
                        required>
                </div>

                <div class="mb-4">
                    <label class="block mb-2">Email</label>

                    <input
                        type="email"
                        name="email"
                        class="w-full border rounded-lg px-4 py-2"
                        required>
                </div>

                <div class="mb-4">
                    <label class="block mb-2">Password</label>

                    <input
                        type="password"
                        name="password"
                        class="w-full border rounded-lg px-4 py-2"
                        required>
                </div>

                <div class="mb-4">
                    <label class="block mb-2">Role</label>

                    <select
                        name="role"
                        class="select2 w-full border rounded-lg px-4 py-2">

                        <option value="admin">
                            Admin
                        </option>
                        <option value="siswa">
                            Siswa
                        </option>

                    </select>


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

        <!-- Modal Edit User -->

        <div id="editModal"
            class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 overflow-y-auto p-4">
            <div class="bg-white rounded-xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto my-8">

                <h2 class="text-xl font-bold mb-5">
                    Edit User
                </h2>


                <form id="editForm" method="POST">

                    @csrf
                    @method('PUT')


                    <div class="mb-4">

                        <label class="block mb-2">
                            Nama
                        </label>

                        <input
                            id="edit_name"
                            type="text"
                            name="name"
                            class="w-full border rounded-lg px-4 py-2"
                            required>

                    </div>


                    <div class="mb-4">

                        <label class="block mb-2">
                            Email
                        </label>

                        <input
                            id="edit_email"
                            type="email"
                            name="email"
                            class="w-full border rounded-lg px-4 py-2"
                            required>

                    </div>


                    <div class="mb-4">

                        <label class="block mb-2">
                            Password
                        </label>

                        <input
                            id="edit_password"
                            type="password"
                            name="password"
                            class="w-full border rounded-lg px-4 py-2">

                        <small class="text-gray-500">
                            Kosongkan jika tidak ingin mengganti password
                        </small>

                    </div>

                    <!-- Tambahkan Role di sini -->

                    <div class="mb-4">

                        <label class="block mb-2">
                            Role
                        </label>

                        <select
                            id="edit_role"
                            name="role"
                            class="w-full border rounded-lg px-4 py-2">

                            <option value="admin">
                                Admin
                            </option>

                            <option value="siswa">
                                Siswa
                            </option>

                        </select>

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
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                            Update

                        </button>


                    </div>


                </form>


            </div>

        </div>

        <script>
            $.get("/user/data", function(data) {

                $("#userGrid").dxDataGrid({

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
                        placeholder: "Cari user..."
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
                        fileName: "Data User"
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
                            dataField: "name",
                            caption: "Nama",
                            minWidth: 180
                        },

                        {
                            dataField: "email",
                            caption: "Email",
                            minWidth: 250
                        },

                        {
                            dataField: "role",
                            caption: "Role",
                            width: 130,
                            alignment: "center",

                            cellTemplate: function(container, options) {

                                let background = "";
                                let shadow = "";

                                if (options.value == "admin") {

                                    background = "linear-gradient(135deg,#2563EB,#3B82F6)";
                                    shadow = "0 6px 15px rgba(37,99,235,.35)";

                                } else {

                                    background = "linear-gradient(135deg,#16A34A,#22C55E)";
                                    shadow = "0 6px 15px rgba(34,197,94,.35)";

                                }

                                $("<span>")
                                    .text(options.value.charAt(0).toUpperCase() + options.value.slice(1))
                                    .css({
                                        background: background,
                                        color: "#fff",
                                        padding: "8px 16px",
                                        borderRadius: "999px",
                                        fontSize: "13px",
                                        fontWeight: "700",
                                        display: "inline-block",
                                        boxShadow: shadow
                                    })
                                    .appendTo(container);

                            }

                        },

                        {
                            caption: "Aksi",
                            width: 220,
                            fixed: true,
                            fixedPosition: "right",
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
                                            options.data.name,
                                            options.data.email,
                                            options.data.role
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
                                            form.action = "/user/" + options.data.id;
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

                document.getElementById("tambahModal").classList.remove("hidden");
                document.getElementById("tambahModal").classList.add("flex");

            }

            function closeTambahModal() {

                document.getElementById("tambahModal").classList.add("hidden");
                document.getElementById("tambahModal").classList.remove("flex");

            }

            function openEditModal(id, name, email, role) {

                document.getElementById("editModal").classList.remove("hidden");
                document.getElementById("editModal").classList.add("flex");

                document.getElementById("editForm").action = "/user/" + id;

                document.getElementById("edit_name").value = name;
                document.getElementById("edit_email").value = email;
                document.getElementById("edit_role").value = role;

            }

            function closeEditModal() {

                document.getElementById("editModal").classList.add("hidden");
                document.getElementById("editModal").classList.remove("flex");

            }
        </script>

</x-app-layout>