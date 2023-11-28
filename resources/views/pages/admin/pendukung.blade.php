@extends('layouts.main')

@section('title', 'Dashboard Admin - Relawan')

@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-semibold">Daftar Pendukung</h1>
        </div>
        <div class="relative overflow-x-auto sm:rounded-lg">
            <table id="relawan" class="w-full text-left text-sm text-gray-500 rtl:text-right">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3">
                            NIK
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Alamat
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Desa
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kecamatan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Relawan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendukung as $item)
                        <tr class="border-b odd:bg-white even:bg-gray-50">
                            <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                                {{ $item->name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $item->nik }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->detail_alamat }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->desa }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->kec }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->tps->name }}
                            </td>
                            <td class="px-6 py-4">
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
            {{ $pendukung->links('pagination::tailwind') }}
        </div>
        <div id="tambah-relawan" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
            <div class="relative max-h-full w-full max-w-md p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Tambah Relawan
                        </h3>
                        <button type="button" class="end-2.5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900" data-modal-hide="tambah-relawan">
                            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <form class="space-y-4" id="add-relawan">
                            @csrf
                            <div>
                                <label for="name" class="mb-2 block text-sm font-medium text-gray-900">Nama Relawan</label>
                                <input type="text" name="name" id="name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan nama relawan" required>
                            </div>
                            <div>
                                <label for="email" class="mb-2 block text-sm font-medium text-gray-900">Email</label>
                                <input type="email" name="email" id="email" placeholder="relawan@gmail.com" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label for="password" class="mb-2 block text-sm font-medium text-gray-900">Pasword Relawan</label>
                                <input type="password" name="password" id="password" placeholder="Password akun relawan" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            <input value="1" name="role" class="hidden" />
                            <button type="submit" class="mb-4 w-full rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300">Login to your account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection