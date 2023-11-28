@extends('layouts.main')

@section('title', 'Login')

@section('content')
    <div class="pt:mt-0 mx-auto flex h-screen flex-col items-center justify-center bg-primary px-6">
        <div class="w-full max-w-lg space-y-8 rounded-lg bg-white p-6 shadow-xl sm:p-8">
            <h2 class="text-center text-2xl font-bold text-gray-900">
                Buat Akun Admin
            </h2>
            @if (session('error'))
                <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">{{ session('error') }}!</span> Gagal membuat akun.
                </div>
            @endif
            <form class="mt-8 space-y-6" action="{{ route('auth.registerPost') }}" method="POST">
                @csrf
                <input type="hidden" name="role" value="0" />
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-gray-900">Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="focus:ring-primary-500 focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm" placeholder="Masukkan nama Anda" value="{{ old('name') }}" required>
                </div>
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-gray-900">E-mail</label>
                    <input type="email" name="email" id="email" class="focus:ring-primary-500 focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm" placeholder="name@company.com" value="{{ old('email') }}" required>
                </div>
                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-gray-900"> Password</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary focus:ring-primary" value="{{ old('password') }}" required>
                </div>
                <div>
                    <label for="confirm_password" class="mb-2 block text-sm font-medium text-gray-900"> Konfirmasi Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="••••••••" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary focus:ring-primary" value="{{ old('confirm_password') }}" required>
                </div>
                <button type="submit" class="bg-primary-700 hover:bg-primary-800 focus:ring-primary-300 w-full rounded-lg bg-primary px-5 py-3 text-center text-base font-medium text-white focus:ring-4 sm:w-auto">Daftar Akun</button>
                <div class="text-sm font-medium text-gray-500">
                    Sudah punya akun? <a href="{{ route('auth.register') }}" class="text-primary-700 cursor-pointer hover:underline">Masuk</a>
                </div>
            </form>
        </div>
    </div>
@endsection
