@extends('layouts.main')

@section('title', 'Dashboard Admin')

@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
        <h1 class="mb-6 text-3xl font-semibold">Dashboard Admin</h1>
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="block rounded-lg border border-gray-200 bg-white p-6 shadow">
                <h5 class="mb-2 text-xl font-semibold text-gray-900">Jumlah Relawan</h5>
                <p class="font-normal text-gray-700">{{ $relawanCount }} Orang</p>
            </div>
            <div class="block rounded-lg border border-gray-200 bg-white p-6 shadow">
                <h5 class="mb-2 text-xl font-semibold text-gray-900">Jumlah Pendukung</h5>
                <p class="font-normal text-gray-700">{{ $pendukungCount }} Orang</p>
            </div>
            <div class="block rounded-lg border border-gray-200 bg-white p-6 shadow">
                <h5 class="mb-2 text-xl font-semibold text-gray-900">Jumlah Relawan</h5>
                <p class="font-normal text-gray-700">{{ $candidateCount }} Orang</p>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="block rounded-lg border border-gray-200 bg-white p-6 shadow">
                <h5 class="mb-4 text-xl font-semibold text-gray-900">Profil Saya</h5>
                <div class="flex flex-col gap-y-4">
                    <div>
                        <label for="nomor_urut" class="mb-2 block text-sm font-medium text-gray-900">Nama Lengkap</label>
                        <input id="nomor_urut" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:outline-none" value="Admin" disabled />
                    </div>
                    <div>
                        <label for="nomor_urut" class="mb-2 block text-sm font-medium text-gray-900">Email</label>
                        <input id="nomor_urut" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:outline-none" value="admin@gmail.com" disabled />
                    </div>
                    <div>
                        <label for="nomor_urut" class="mb-2 block text-sm font-medium text-gray-900">Peran</label>
                        <input id="nomor_urut" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:outline-none" value="Admin" disabled />
                    </div>
                </div>
            </div>
            <div class="block rounded-lg border border-gray-200 bg-white p-6 shadow sm:col-span-2">
                <h5 class="mb-1 text-xl font-semibold text-gray-900">Top 5 Relawan</h5>
                <p class="mb-4 text-gray-500">Dengan pendukung terbanyak</p>
                <div id="performaRelawan"></div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        var options = {!! $chartJson !!};

        var chart = new ApexCharts(document.querySelector("#performaRelawan"), options);

        chart.render();
    </script>
@endpush
