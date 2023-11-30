@extends('layouts.main')

@section('title', 'Dashboard Admin | Tambah Candidate')

@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800" role="alert">
                <span class="font-medium">{{ session('success') }}!</span>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800" role="alert">
                <span class="font-medium">{{ session('error') }}!</span>
            </div>
        @endif
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-semibold">Tambah Kandidat</h1>
        </div>
        <div>
            <form action="{{ route('dashboard.candidate.store') }}" class="flex flex-col gap-4" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="flex flex-col gap-4">
                        <div>
                            <label for="nomor_urut" class="mb-2 block text-sm font-medium text-gray-900">Nomor Urut</label>
                            <input type="text" name="nomor_urut" id="nomor_urut" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:outline-none" placeholder="Masukkan nomor urut" required />
                        </div>
                        <div>
                            <label for="name" class="mb-2 block text-sm font-medium text-gray-900">Nama Candidate</label>
                            <input type="text" name="name" id="name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:outline-none" placeholder="Masukkan nama kandidat" required />
                        </div>
                        <div>
                            <label for="jenis_kelamin" class="mb-2 block text-sm font-medium text-gray-900">Jenis Kelamin</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:outline-none">
                                <option disabled selected>Pilih jenis kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4">
                        <div>
                            <label for="partai" class="mb-2 block text-sm font-medium text-gray-900">Partai</label>
                            <input type="text" name="partai" id="partai" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:outline-none" placeholder="Masukkan nama partai" required />
                        </div>
                        <div>
                            <label for="tempat_tinggal" class="mb-2 block text-sm font-medium text-gray-900">Tempat Tinggal</label>
                            <input type="text" name="tempat_tinggal" id="tempat_tinggal" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:outline-none" placeholder="Masukkan tempat tinggal" required />
                        </div>
                        <div>
                            <label for="image" class="mb-2 block text-sm font-medium text-gray-900">Pas Photo</label>
                            <input type="file" name="image" id="image" class="block w-full rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 file:bg-primary focus:outline-none" required />
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-x-4">
                    <button onclick="window.history.go(-1)" class="mb-4 mt-8 rounded-lg bg-neutral-400 px-5 py-2.5 text-center text-sm font-medium text-white transition-colors duration-300 hover:bg-neutral-500 focus:outline-none">Kembali</button>
                    <button type="submit" class="mb-4 mt-8 rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white transition-colors duration-300 hover:bg-blue-800 focus:outline-none">Tambah Candidate</button>
                </div>
            </form>
        </div>
    </div>
@endsection
