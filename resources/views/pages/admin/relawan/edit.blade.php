@extends('layouts.main')

@section('title', 'Dashboard Admin | Relawan')

@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-semibold">Edit Relawan</h1>
        </div>
        <form class="space-y-4" id="edit-relawan">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-gray-900">Nama Relawan</label>
                <input type="text" value="{{ $user->name }}" name="name" id="name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan nama relawan" required>
            </div>
            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-gray-900">Email</label>
                <input type="email" value="{{ $user->email }}" name="email" id="email" placeholder="relawan@gmail.com" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" required>
            </div>

            <input value="1" name="role" class="hidden" />

            <div class="flex justify-end gap-x-4">
                <a href="{{ route('dashboard.admin.index') }}" class="mb-4 mt-8 rounded-lg bg-neutral-400 px-5 py-2.5 text-center text-sm font-medium text-white transition-colors duration-300 hover:bg-neutral-500 focus:outline-none">Kembali</a>
                <button type="submit" class="mb-4 mt-8 rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white transition-colors duration-300 hover:bg-blue-800 focus:outline-none">Simpan</button>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        $('#edit-relawan').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ route('dashboard.admin.update', $user->id) }}",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                success: function(response) {
                    Swal.fire({
                        title: "Success",
                        text: response.message,
                        icon: "success",
                        delay: 1000
                    }).then(() => {
                        window.location.href = "{{ route('dashboard.admin.index') }}"
                    })
                },
                error: function(error) {
                    Swal.fire({
                        title: "Error",
                        text: error.responseJSON.message,
                        icon: "error",
                        delay: 1000
                    })
                }
            })
        })
    </script>
@endpush
