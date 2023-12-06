@extends('layouts.main')

@section('title', 'Register')

@section('content')
    <div class="pt:mt-0 mx-auto flex h-screen flex-col items-center justify-center bg-primary px-6">
        <div class="w-full max-w-lg space-y-8 rounded-lg bg-white p-6 shadow-xl sm:p-8">
            <h2 class="text-center text-2xl font-bold text-gray-900">
                Buat Akun Admin
            </h2>
            <form class="mt-8 flex flex-col gap-y-6" action="{{ route('auth.registerPost') }}" method="POST">
                @csrf
                <input type="hidden" name="role" value="0" />
                <x-input label="Nama Lengkap" id="name" type="text" placeholder="Masukkan nama Anda" required />
                <x-input label="E-mail" id="email" type="email" placeholder="Masukkan email Anda" required />
                <x-input label="Password" id="password" type="password" placeholder="••••••••" required />
                <x-input label="Konfirmasi Password" id="confirm_password" type="password" placeholder="••••••••" required />
                <button type="submit" class="bg-primary-700 hover:bg-primary-800 focus:ring-primary-300 w-full rounded-lg bg-primary px-5 py-3 text-center text-base font-medium text-white focus:ring-4 sm:w-auto">Daftar Akun</button>
                <div class="text-sm font-medium text-gray-500">
                    Sudah punya akun? <a href="{{ route('auth.login') }}" class="text-primary-700 cursor-pointer hover:underline">Masuk</a>
                </div>
            </form>
        </div>
    </div>
@endsection
