@extends('layouts.main')

@section('title', 'Dashboard Admin | Detail Kandidat')

@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold sm:text-3xl">Detail Kandidat</h1>
            <a href="{{ route('dashboard.candidate.index') }}" class="rounded-lg bg-primary px-5 py-2.5 text-white transition-colors duration-200 hover:bg-blue-600 focus:outline-none">Back</a>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="pr-4">
                <img class="w-full rounded-lg object-cover sm:w-96 md:h-auto" src="{{ asset('storage/candidate/' . $candidate->image) }}" alt="{{ $candidate->name }}">
            </div>
            <div class="flex flex-col gap-4">
                <div>
                    <label for="nomor_urut" class="mb-2 block text-sm font-medium text-gray-900">Nomor Urut</label>
                    <input id="nomor_urut" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:outline-none" placeholder="Masukkan nomor urut" value="{{ $candidate->nomor_urut }}" disabled />
                </div>
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-gray-900">Nama Kandidat</label>
                    <input type="text" name="name" value="{{ $candidate->name }}" id="name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan nama relawan" disabled />
                </div>
                <div>
                    <label for="jenis_kelamin" class="mb-2 block text-sm font-medium text-gray-900">Jenis Kelamin</label>
                    <input value="{{ $candidate->jenis_kelamin }}" id="partai" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan nama relawan" disabled />
                </div>
            </div>
            <div class="flex flex-col gap-4">
                <div>
                    <label for="partai" class="mb-2 block text-sm font-medium text-gray-900">Partai</label>
                    <input value="{{ $candidate->partai }}" id="partai" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan nama relawan" disabled />
                </div>
                <div>
                    <label for="tempat_tinggal" class="mb-2 block text-sm font-medium text-gray-900">Tempat Tinggal</label>
                    <input value="{{ $candidate->tempat_tinggal }}" id="tempat_tinggal" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan nama relawan" disabled />
                </div>
            </div>
        </div>
    </div>
@endsection
