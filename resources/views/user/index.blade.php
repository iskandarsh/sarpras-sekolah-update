<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

            <h2 class="font-bold text-2xl text-gray-800">
                Data User
            </h2>

            <button
                onclick="openTambahModal()"
                class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">

                + Tambah User

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

            <form method="GET" action="{{ route('user.index') }}" class="mb-5">

                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama atau email..."
                        class="border rounded-lg px-4 py-2">

                    <select
                        name="role"
                        class="border rounded-lg px-4 py-2">

                        <option value="">Semua Role</option>

                        <option value="admin"
                            {{ request('role') == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                        <option value="user"
                            {{ request('role') == 'user' ? 'selected' : '' }}>
                            User
                        </option>

                    </select>

                    <div class="flex gap-2">

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                            Cari

                        </button>

                        <a
                            href="{{ route('user.index') }}"
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

                                <th class="hidden md:table-cell px-3 md:px-6 py-3">
                                    No
                                </th>

                                <th class="px-6 py-3 text-left">
                                    Nama
                                </th>

                                <th class="hidden md:table-cell px-3 md:px-6 py-3">
                                    Email
                                </th>

                                <th class="px-6 py-3 text-center">
                                    Role
                                </th>

                                <th class="px-6 py-3 text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>
                            @foreach($users as $user)

                            <tr class="border-b hover:bg-gray-50">

                                <td class="hidden md:table-cell px-3 md:px-6 py-4">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $user->name }}
                                </td>

                                <td class="hidden md:table-cell px-3 md:px-6 py-4">
                                    {{ $user->email }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ ucfirst($user->role) }}
                                </td>

                                <td class="px-6 py-4">

                                    @if(Auth::user()->role == 'admin')

                                    <div class="flex justify-center gap-2">

                                        <button
                                            onclick="openEditModal(
    '{{ $user->id }}',
    '{{ $user->name }}',
    '{{ $user->email }}',
    '{{ $user->role }}'
)"
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded">
                                            Edit
                                        </button>

                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST">
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

                            @endforeach

                        </tbody>

                    </table>

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

                <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button
                        onclick="return confirm('Yakin ingin menghapus user ini?')"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                        Hapus
                    </button>
                </form>

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
                        class="w-full border rounded-lg px-4 py-2">

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



            function openEditModal(id, name, email, role) {


                document.getElementById('editModal')
                    .classList.remove('hidden');

                document.getElementById('editModal')
                    .classList.add('flex');


                document.getElementById('editForm').action =
                    '/user/' + id;


                document.getElementById('edit_name').value = name;

                document.getElementById('edit_email').value = email;

                document.getElementById('edit_password').value = '';

                document.getElementById('edit_role').value = role;


            }



            function closeEditModal() {


                document.getElementById('editModal')
                    .classList.add('hidden');


                document.getElementById('editModal')
                    .classList.remove('flex');


            }
        </script>

</x-app-layout>