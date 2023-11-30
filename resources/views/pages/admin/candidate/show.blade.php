@extends('layouts.main')

@section('title', 'Dashboard Admin | Detail Kandidat')

@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
      <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-semibold">Detail Kandidat</h1>
        <a href="{{ route('dashboard.candidate.index') }}" class="rounded-lg bg-primary px-5 py-2.5 text-white transition-colors duration-200 hover:bg-blue-600 focus:outline-none">Back</a>
      </div>
      
      <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
        <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" src="{{ asset('storage/candidate/'.$candidate->image) }}" alt="">
        <div class="flex flex-col justify-between p-4 leading-normal">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Profil Kandidat</h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Nama : {{ $candidate->name }}</p>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Partai : {{ $candidate->partai }}</p>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Nomor Urut : {{ $candidate->nomor_urut }}</p>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Jenis Kelamin : {{ $candidate->jenis_kelamin }}</p>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Tempat Tinggal : {{ $candidate->tempat_tinggal }}</p>
        </div>
      </div>
    </div>
@endsection
