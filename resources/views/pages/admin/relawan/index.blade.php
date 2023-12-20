@extends('layouts.main')

@section('title', 'Dashboard Admin | Relawan')

@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
        <div class="mb-6 flex flex-col items-start justify-between gap-y-3 md:flex-row md:items-center">
            <h1 class="text-3xl font-semibold">Daftar Relawan</h1>
            <a href="{{ route('dashboard.admin.create') }}" class="rounded-lg bg-primary px-5 py-2.5 text-white transition-colors duration-200 hover:bg-blue-600 focus:outline-none">Tambah Relawan</a>
        </div>
        <div class="mb-6 flex flex-col items-start justify-between gap-y-3 md:flex-row md:items-center">
            <div class="flex items-center gap-x-4">
                <p class="flex-grow text-sm">Show per page(s):</p>
                <select id="showPerPages" class="rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                    <option value="10">10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="relative flex-shrink self-stretch">
                <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                    <i class='bx bx-search text-xl text-gray-500'></i>
                </div>
                <input type="search" id="search" name="search" class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Cari data disini...">
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
                <tbody></tbody>
            </table>
        </div>
        <div id="pagination" class="mt-4"></div>
    </div>
@endsection

@push('script')
    <script>
        fetchData();

        function fetchData(query = '', page = 1, perPage = 10) {
            $.ajax({
                url: "{{ route('dashboard.admin.search.relawan') }}",
                method: "GET",
                data: {
                    query: query,
                    page: page,
                    perPage: perPage
                },
                dataType: 'json',
                success: function(data) {
                    $('tbody').html(data.table_data);
                    $('#pagination').html(data.pagination);
                }
            })
        }

        $(document).on('keyup', '#search', function() {
            var query = $(this).val();
            fetchData(query);
        });

        $(document).on('click', '#pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetchData($('#search').val(), page);
        });

        $(document).on('change', '#showPerPages', function() {
            var perPage = $(this).val();
            fetchData($('#search').val(), 1, perPage);
        });

        function handleDelete(id) {
            console.log(id)
            Swal.fire({
                title: 'Yakin ingin menghapus data?',
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                buttons: true,
                dangerMode: true,
            }).then((result) => {
                if (result.isConfirmed) {
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
                            Swal.fire(
                                'Data berhasil dihapus!',
                                response.message,
                            ).then(() => {
                                window.location.reload()
                            })
                        },
                        error: function(response) {
                            Swal.fire({
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
