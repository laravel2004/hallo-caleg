@extends('layouts.main')

@section('title', 'Quickcount | Dashboard Relawan')

@section('content')
    <x-sidebarRelawan />
    <div class="p-6 sm:ml-64">
      <div class="mb-8 flex items-center justify-between">
        <h1 class="text-3xl font-semibold">Quickcount</h1>
        <a href="{{ route('dashboard.quickcount.create') }}" class="rounded-lg bg-primary px-5 py-2.5 text-white transition-colors duration-200 hover:bg-blue-600 focus:outline-none"  >Tambah Pedukung</a >
      </div>
      
    </div>
@endsection
