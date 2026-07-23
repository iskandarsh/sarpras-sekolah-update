<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">
            Activity Log
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-xl shadow-lg">

                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead class="bg-blue-600 text-white">

                            <tr>

                                <th class="px-6 py-3 text-center">
                                    No
                                </th>

                                <th class="px-6 py-3">
                                    Admin
                                </th>

                                <th class="px-6 py-3">
                                    Aktivitas
                                </th>

                                <th class="px-6 py-3">
                                    Waktu
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($logs as $log)

                            <tr class="border-b hover:bg-gray-50">

                                <td class="px-6 py-4 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $log->user->name }}
                                </td>

                                <td class="px-6 py-4">

                                    @if(Str::contains($log->aktivitas,'Menambahkan'))

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                        Tambah
                                    </span>

                                    @elseif(Str::contains($log->aktivitas,'Mengubah'))

                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                                        Edit
                                    </span>

                                    @elseif(Str::contains($log->aktivitas,'Menghapus'))

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                        Hapus
                                    </span>

                                    @endif

                                    <span class="ml-2">
                                        {{ $log->aktivitas }}
                                    </span>

                                </td>

                                <td class="px-6 py-4">
                                    {{ $log->created_at->format('d M Y H:i') }}
                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="4" class="text-center py-8 text-gray-500">

                                    Belum ada aktivitas.

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>