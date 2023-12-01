@extends('layouts.main')

@section('title', 'Dashboard Admin | Edit Candidate')

@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-semibold">Edit Kandidat</h1>
        </div>
        <form action="{{ route('dashboard.candidate.update', $candidate->id) }}" class="flex flex-col gap-4" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                <div class="pr-4">
                    <img class="w-full rounded-lg object-cover sm:w-96 md:h-auto" src="{{ asset('storage/candidate/' . $candidate->image) }}" alt="{{ $candidate->name }}">
                </div>
                <div class="flex flex-col gap-4">
                    <div>
                        <label for="nomor_urut" class="mb-2 block text-sm font-medium text-gray-900">Nomor Urut</label>
                        <input type="text" name="nomor_urut" id="nomor_urut" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:outline-none" placeholder="Masukkan nomor urut" value="{{ $candidate->nomor_urut }}" required />
                    </div>
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-900">Nama Kandidat</label>
                        <input type="text" name="name" value="{{ $candidate->name }}" id="name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan nama relawan" required />
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="mb-2 block text-sm font-medium text-gray-900">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:outline-none">
                            <option disabled>Pilih jenis kelamin</option>
                            <option value="Laki-laki" @if ($candidate->jenis_kelamin == 'Laki-laki') checked @endif>Laki-laki</option>
                            <option value="Perempuan" @if ($candidate->jenis_kelamin == 'Perempuan') checked @endif>Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <div>
                        <label for="partai" class="mb-2 block text-sm font-medium text-gray-900">Partai</label>
                        <input type="text" name="partai" value="{{ $candidate->partai }}" id="partai" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan nama relawan" required />
                    </div>
                    <div>
                        <label for="tempat_tinggal" class="mb-2 block text-sm font-medium text-gray-900">Tempat Tinggal</label>
                        <input type="text" name="tempat_tinggal" value="{{ $candidate->tempat_tinggal }}" id="tempat_tinggal" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan nama relawan" required />
                    </div>
                    <div>
                        <label for="image" class="mb-2 block text-sm font-medium text-gray-900">Pas Photo</label>
                        <input type="file" name="image" id="image" class="block w-full rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan nama relawan" />
                    </div>

                </div>
            </div>
            <div class="flex justify-end gap-x-4">
                <a href="{{ route('dashboard.candidate.index') }}" class="mb-4 mt-8 rounded-lg bg-neutral-400 px-5 py-2.5 text-center text-sm font-medium text-white transition-colors duration-300 hover:bg-neutral-500 focus:outline-none">Kembali</a>
                <button type="submit" class="mb-4 mt-8 rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white transition-colors duration-300 hover:bg-blue-800 focus:outline-none">Simpan</button>
            </div>
        </form>
    </div>
@endsection
