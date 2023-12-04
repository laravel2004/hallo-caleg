@extends('layouts.main')

@section('title', 'Dashboard Relawan | Tambah Pendukung')

@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-semibold">Tambah Pendukung</h1>
        </div>
        <form id="add-pendukung" class="grid">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="flex flex-col gap-4">
                    <div>
                        <label for="nik" class="mb-2 block text-sm font-medium text-gray-900">NIK</label>
                        <input type="text" id="nik" name="nik" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan NIK pendukung" />
                    </div>
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-900">Nama</label>
                        <input type="text" id="name" name="name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan nama pendukung " />
                    </div>
                    <div>
                        <label for="detail_alamat" class="mb-2 block text-sm font-medium text-gray-900">Detail Alamat</label>
                        <textarea type="text" id="detail_alamat" name="detail_alamat" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan Detail alamat "></textarea>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <div>
                        <label for="kecamatan" class="mb-2 block text-sm font-medium text-gray-900">Kecamatan</label>
                        <select id="kecamatan" name="kec" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                            <option>Pilih Kecamatan</option>
                        </select>

                    </div>
                    <div>
                        <label for="desa" class="mb-2 block text-sm font-medium text-gray-900">Desa</label>
                        <select id="desa" name="desa" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                            <option>Pilih Desa</option>
                        </select>
                    </div>
                    <div>
                        <label for="tps" class="mb-2 block text-sm font-medium text-gray-900">TPS</label>
                        <select id="tps" name="tps_id" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                            <option>Pilih TPS</option>
                        </select>
                    </div>
                </div>
            </div>
            <input type="hidden" id="user" name="user_id" value="{{ Auth::user()->id }}" />
            <div class="mt-8 flex justify-end gap-x-4">
                <a href="{{ route('dashboard.relawan.pendukung') }}" class="rounded-lg bg-neutral-400 px-5 py-2.5 text-center text-sm font-medium text-white transition-colors duration-300 hover:bg-neutral-500 focus:outline-none">Kembali</a>
                <button type="submit" class="rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white transition-colors duration-300 hover:bg-blue-800 focus:outline-none">Tambah Pendukung</button>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('utility.area.district') }}",
                method: "GET",
                data: {
                    id: 261
                },
                dataType: "JSON",
                success: function(data) {
                    $('#kecamatan').empty();
                    $('#kecamatan').append('<option>Pilih Kecamatan</option>');
                    $.each(data, function(key, value) {
                        console.log(key);
                        $('#kecamatan').append('<option value="' + key + '">' + value + '</option>');
                    })
                },
                error: function(data) {
                    $('#kecamatan').empty();
                    $('#kecamatan').append('<option>Kesalahan Mengambil data</option>');
                }
            })
        })

        $(document).on('change', '#kecamatan', function() {
            var id = $(this).val();
            $.ajax({
                url: "{{ route('utility.area.sub-district') }}",
                method: "GET",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    $('#desa').empty();
                    $('#desa').append('<option>Pilih Desa</option>');
                    $.each(data, function(key, value) {
                        $('#desa').append('<option value="' + key + '">' + value + '</option>');
                    })
                },
                error: function(data) {
                    $('#desa').empty();
                    $('#desa').append('<option>Kesalahan Mengambil data</option>');
                }
            })
        })

        $(document).on('change', '#desa', function() {
            var id = $(this).val();
            $.ajax({
                url: "{{ route('utility.area.tps') }}",
                method: "GET",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    console.log(data)
                    $('#tps').empty();
                    $('#tps').append('<option>Pilih TPS</option>');
                    $.each(data.message, function(key, value) {
                        $('#tps').append('<option value="' + value.id + '">' + value.name + '</option>');
                    })
                },
                error: function(data) {
                    $('#tps').empty();
                    $('#tps').append('<option>Kesalahan Mengambil data</option>');
                }
            })
        })

        $('#add-pendukung').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ route('dashboard.relawan.pendukung.store') }}",
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
                        window.location.href = "{{ route('dashboard.relawan.pendukung') }}"
                    })
                },
                error: function(error) {
                    Swal.fire({
                        title: "Error",
                        text: error.responseJSON.message,
                        icon: "error",
                        delay: 1000
                    })
                },
            })
        })
    </script>
@endpush
