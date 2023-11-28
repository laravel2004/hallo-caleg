@extends('layouts.main')

@section('title', 'Dashboard Admin | Relawan')

@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-semibold">Daftar Relawan</h1>
            <a href="{{ route('dashboard.admin.create') }}" class="rounded-lg bg-primary px-5 py-2.5 text-white transition-colors duration-200 hover:bg-blue-600 focus:outline-none">Tambah Relawan</a>
        </div>
        <div class="mb-6 flex items-center justify-between">
            <div class="flex items-center gap-x-4">
                <p class="flex-grow text-sm">Show per page(s):</p>
                <select id="showPerPages" class="rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                    <option value="10">10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="relative flex-shrink">
                <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                    <i class='bx bx-search text-xl text-gray-500'></i>
                </div>
                <input type="search" id="search" name="search" class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Cari data disini..." value="{{ old('search') }}">
            </div>
        </div>
        <div class="relative overflow-x-auto sm:rounded-lg">
            <table id="relawan" class="w-full text-left text-sm text-gray-500 rtl:text-right">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Jumlah Pendukung
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($relawan as $item)
                        <tr class="border-b odd:bg-white even:bg-gray-50">
                            <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                                {{ $item->name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $item->email }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->pendukungs->count() }}
                            </td>
                            <td class="flex items-center gap-x-4 px-6 py-4">
                                <a href="{{ route('dashboard.admin.edit', $item->id) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                                <a href="" onclick="handleDelete({{ $item->id }})" class="font-medium text-red-600 hover:underline">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-500">
                                Tidak ada data yang dapat ditampilkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $relawan->appends(['search' => request('search'), 'per_page' => request('per_page')])->links('pagination::tailwind') }}
        </div>
    </div>
@endsection

@push('script')
    <script>
        function handleDelete(id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'DELETE',
                        url: "{{ route('dashboard.admin.destroy', ':id') }}".replace(':id', id),
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            id: id
                        },
                        success: function(response) {
                            swal({
                                title: "Success",
                                text: response.message,
                                icon: "success",
                                delay: 1000,
                                button: false,
                            })
                            window.location.reload()
                        },
                        error: function(response) {
                            swal({
                                title: "Error",
                                text: response.message,
                                icon: "error",
                                delay: 1000,
                                button: false,
                            })
                        }
                    })
                }
            })
        }
    </script>
@endpush
