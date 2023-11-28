@extends('layouts.main')

@section('title', 'Dashboard Admin - Relawan')

@push('style')
@endpush

@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-semibold">Daftar Relawan</h1>
            <button data-modal-target="tambah-relawan" data-modal-toggle="tambah-relawan" class="rounded-lg bg-primary px-5 py-2.5 text-white transition-colors duration-200 hover:bg-blue-600 focus:outline-none">Tambah Relawan</button>
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
                            Action
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
                                <a href="#" class="font-medium text-blue-600 hover:underline">Edit</a>
                                <a href="#" class="font-medium text-red-600 hover:underline">Hapus</a>
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
        $('#add-relawan').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ route('dashboard.admin.store') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    swal({
                        title: "Success",
                        text: response.message,
                        icon: "success",
                        delay: 1000
                    })
                    location.reload();
                },
                error: function(error) {
                    swal({
                        title: "Error",
                        text: error.responseJSON.message,
                        icon: "error",
                        delay: 1000,
                        dangerMode: true
                    })
                }
            });
        })
    </script>
@endpush
