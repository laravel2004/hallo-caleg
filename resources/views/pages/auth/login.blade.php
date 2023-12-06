@extends('layouts.main')

@section('title', 'Login')

@section('content')
    <div class="pt:mt-0 mx-auto flex h-screen flex-col items-center justify-center bg-primary px-6 pt-8">
        <div class="w-full max-w-lg rounded-lg bg-white p-6 shadow-xl sm:p-8">
            <h2 class="text-center text-2xl font-bold text-gray-900">
                Masuk ke akun Anda
            </h2>
            @if (session('success'))
                <div class="mt-6 rounded-md border border-green-600 bg-green-300 p-4 text-center text-green-700">
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mt-6 rounded-md border border-red-600 bg-red-300 p-4 text-center text-red-700">
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif
            <form class="mt-6 flex flex-col gap-y-6" action="{{ route('auth.loginPost') }}" method="POST">
                @csrf
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-gray-900">E-mail</label>
                    <input type="email" name="email" id="email" class="focus:ring-primary-500 focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm" placeholder="name@company.com" required>
                </div>
                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-gray-900"> Password</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" class="focus:ring-primary-500 focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900" required>
                </div>
                <button type="submit" class="bg-primary-700 hover:bg-primary-800 focus:ring-primary-300 w-full rounded-lg bg-primary px-5 py-3 text-center text-base font-medium text-white focus:ring-4 sm:w-auto">Masuk</button>
                {{-- <div class="text-sm font-medium text-gray-500">
                    Belum punya akun? <a href="{{ route('auth.register') }}" class="text-primary-700 cursor-pointer hover:underline">Buat akun</a>
                </div> --}}
            </form>
        </div>
    </div>
@endsection
