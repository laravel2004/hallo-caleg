@extends('layouts.main')

@section('title', 'Quickcount | Dashboard Relawan')

@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
        <div class="mb-6 flex flex-col items-start justify-between gap-y-3 md:flex-row md:items-center">
            <h1 class="text-3xl font-semibold">Quickcount</h1>
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
                            Profil
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Partai
                        </th>
                        <th scope="col" class="px-6 py-3">
                            No urut
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Suara Sah
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
                url: "{{ route('dashboard.relawan.quickcount.search') }}",
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
    </script>
@endpush
