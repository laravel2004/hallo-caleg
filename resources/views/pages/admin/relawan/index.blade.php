@extends('layouts.main')

@section('title', 'Dashboard Admin | Relawan')

@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-semibold">Daftar Relawan</h1>
            <a href="{{ route('dashboard.admin.create') }}" class="rounded-lg bg-primary px-5 py-2.5 text-white transition-colors duration-200 hover:bg-blue-600 focus:outline-none">Tambah Relawan</a>
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
            {{ $relawan->links('pagination::tailwind') }}
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
