@extends('layouts.main')

@section('title', 'Dashboard Admin | Edit Candidate')

@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
      <div class="mb-8 flex items-center justify-between">
        <h1 class="text-3xl font-semibold">Edit Candidate</h1>
        <a href="{{ route('dashboard.candidate.index') }}" class="rounded-lg bg-primary px-5 py-2.5 text-white transition-colors duration-200 hover:bg-blue-600 focus:outline-none"  >Back</a >
      </div>
      <form action="{{ route('dashboard.candidate.update', $candidate->id ) }}" class="flex flex-col gap-4" method="POST">
        @csrf
        @method('PUT')
        <div class="grid gap-4 grid-cols-1 md:grid-cols-2">
          <div class="grid gap-4">
            <div>
              <label for="nomor_urut" class="mb-2 block text-sm font-medium text-gray-900">Nomor Urut</label>
              <input type="text" name="nomor_urut" value="{{ $candidate->nomor_urut }}" id="nomor_urut" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan nama relawan" required />
            </div>
            <div>
              <label for="name" class="mb-2 block text-sm font-medium text-gray-900">Nama Candidate</label>
              <input type="text" name="name" value="{{ $candidate->name }}" id="name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan nama relawan" required />
            </div>
            <div class ="flex gap-4 justify-start">
              <div>
                <label for="jenis_kelamin" class="mb-2 block text-sm font-medium text-gray-900">Laki Laki</label>
                <input type="radio" name="jenis_kelamin" @php
                    if($candidate->jenis_kelamin == 'Laki-Laki'){
                        echo 'checked';
                    }
                @endphp id="jenis_kelamin" value="Laki-Laki" class="block rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" required>
              </div>
              <div>
                <label for="jenis_kelamin" class="mb-2 block text-sm font-medium text-gray-900">Perempuan</label>
                <input type="radio" name="jenis_kelamin" @php
                    if($candidate->jenis_kelamin == 'Perempuan'){
                      echo 'checked';
                    }
                @endphp id="jenis_kelamin" value="Perempuan" class="block rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" required>
              </div>
            </div>
            
          </div>
          <div class="grid gap-4 ">
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
              <input type="file" name="image" id="image" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan nama relawan" />
            </div>
            
          </div>
        </div>
        <button type="submit" class="mb-4 mt-8 rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300">Edit Candidate</button>
      </form>
    </div>
    
@endsection
