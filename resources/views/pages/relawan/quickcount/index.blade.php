@extends('layouts.main')

@section('title', 'Quickcount | Dashboard Relawan')

@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
      <div class="mb-8 flex items-center justify-between">
        <h1 class="text-3xl font-semibold">Quickcount</h1>
        <a href="{{ route('dashboard.quickcount.create') }}" class="rounded-lg bg-primary px-5 py-2.5 text-white transition-colors duration-200 hover:bg-blue-600 focus:outline-none"  >Tambah Pedukung</a >
      </div>
      <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        @if ($candidates->count() > 0)
          @foreach ($candidates as $candidate)
              <x-card-candidate image="{{ $candidate->image }}" name="{{ $candidate->name }}" partai="{{ $candidate->partai }}" />
          @endforeach
        @else
            <div>Tidak ada Kandidat</div>
        @endif
      </div>
    </div>
@endsection
