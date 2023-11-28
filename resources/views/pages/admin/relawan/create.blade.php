@extends('layouts.main')

@section('title', 'Dashboard Admin | Relawan')

@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
      <div class="mb-8 flex items-center justify-between">
        <h1 class="text-3xl font-semibold">Tambah Relawan</h1>
        <a href="{{ route('dashboard.admin.index') }}" class="rounded-lg bg-primary px-5 py-2.5 text-white transition-colors duration-200 hover:bg-blue-600 focus:outline-none"  >Back</a >
      </div>
      <form class="space-y-4" id="add-relawan">
        @csrf
        <div>
            <label for="name" class="mb-2 block text-sm font-medium text-gray-900">Nama Relawan</label>
            <input type="text" name="name" id="name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan nama relawan" required>
        </div>
        <div>
            <label for="email" class="mb-2 block text-sm font-medium text-gray-900">Email</label>
            <input type="email" name="email" id="email" placeholder="relawan@gmail.com" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" required>
        </div>
        <div>
            <label for="password" class="mb-2 block text-sm font-medium text-gray-900">Pasword Relawan</label>
            <input type="password" name="password" id="password" placeholder="Password akun relawan" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" required>
        </div>
        <input value="1" name="role" class="hidden" />
        <button type="submit" class="mb-4 w-full rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300">Daftarkan account relawan</button>
      </form>
    </div>
@endsection

@push('script')
    <script>
      $('#add-relawan').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ route('dashboard.admin.store') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    swal({
                        title: "Success",
                        text: response.message,
                        icon: "success",
                        delay: 1000
                    }).then(() => {
                        window.location.href = "{{ route('dashboard.admin.index') }}"
                    })
                },
                error: function(error) {
                    swal({
                        title: "Error",
                        text: error.responseJSON.message,
                        icon: "error",
                        delay: 1000,
                        dangerMode: true
                    })
                }
            });
        })
    </script>
@endpush