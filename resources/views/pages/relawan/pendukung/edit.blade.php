@extends('layouts.main')

@section('title', 'Dashboard Relawan | Edit Pendukung')

@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-semibold">Edit Pendukung</h1>
        </div>
        <form id="edit-pendukung" class="flex flex-col gap-4" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
                <div class="flex flex-col gap-4">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-900">Nama</label>
                        <input type="text" id="name" name="name" value="{{ $pendukung->name }}" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan nama pendukung " />
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="mb-2 block text-sm font-medium text-gray-900">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                            <option selected disabled>Pilih Jenis Kelamin</option>
                            <option @if ($pendukung->jenis_kelamin == 'L' || $pendukung->jenis_kelamin == 'l') selected @endif value="L">Laki-Laki</option>
                            <option @if ($pendukung->jenis_kelamin == 'P' || $pendukung->jenis_kelamin == 'p') selected @endif value="P">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label for="usia" class="mb-2 block text-sm font-medium text-gray-900">Usia</label>
                        <input type="number" id="usia" name="usia" value="{{ $pendukung->usia }}" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan usia pendukung " />
                    </div>
                    <div>
                        <label for="kecamatan" class="mb-2 block text-sm font-medium text-gray-900">Kecamatan</label>
                        <select id="kecamatan" name="kec" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                            <option selected disabled>Pilih Kecamatan</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <div>
                        <label for="desa" class="mb-2 block text-sm font-medium text-gray-900">Desa</label>
                        <select id="desa" name="desa" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" data-selected="{{ $pendukung->kec }}">
                            <option selected disabled>Pilih Desa</option>
                        </select>
                    </div>
                    <div>
                        <label for="rt" class="mb-2 block text-sm font-medium text-gray-900">RT</label>
                        <input type="number" id="rt" name="rt" value="{{ $pendukung->rt }}" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan RT pendukung, contoh: 1" />
                    </div>
                    <div>
                        <label for="rw" class="mb-2 block text-sm font-medium text-gray-900">RW</label>
                        <input type="number" id="rw" name="rw" value="{{ $pendukung->rw }}" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan RW pendukung, contoh: 1" />
                    </div>
                    <div>
                        <label for="tps" class="mb-2 block text-sm font-medium text-gray-900">TPS</label>
                        <select id="tps" name="tps_id" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                            <option selected disabled>Pilih TPS</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-x-4">
                <a href="{{ route('dashboard.relawan.pendukung') }}" class="mb-4 mt-8 rounded-lg bg-neutral-400 px-5 py-2.5 text-center text-sm font-medium text-white transition-colors duration-300 hover:bg-neutral-500 focus:outline-none">Kembali</a>
                <button type="submit" class="mb-4 mt-8 rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white transition-colors duration-300 hover:bg-blue-800 focus:outline-none">Simpan</button>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        var selectedDesa = "{!! $pendukung->desa !!}";
        var selectedTPS = "{!! $pendukung->tps_id !!}";
        console.log(selectedTPS);
        $(document).ready(function() {
            var selectedKecamatan = "{{ $pendukung->kec }}";

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
                        console.log(value);
                        var selected = (value.toString() == selectedKecamatan.toString()) ? 'selected' : '';
                        $('#kecamatan').append('<option value="' + key + '" ' + selected + '>' + value + '</option>');
                    });
                    $('#kecamatan').trigger('change');
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
                        var selected = (value.toString() == selectedDesa.toString()) ? 'selected' : '';
                        $('#desa').append('<option value="' + key + '" ' + selected + '>' + value + '</option>');
                    })
                    $('#desa').trigger('change');
                },
                error: function(data) {
                    $('#desa').empty();
                    $('#desa').append('<option>Kesalahan Mengambil data</option>');
                }
            })
        })

        $(document).on('change', '#desa', function() {
            var selectedTPS = "{{ $pendukung->tps_id }}";
            var id = $(this).val();
            $.ajax({
                url: "{{ route('utility.area.tps') }}",
                method: "GET",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    $('#tps').empty();
                    $('#tps').append('<option>Pilih TPS</option>');
                    $.each(data.message, function(key, value) {
                        var selected = (value.id == selectedTPS) ? 'selected' : '';
                        $('#tps').append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                    })
                },
                error: function(data) {
                    $('#tps').empty();
                    $('#tps').append('<option>Kesalahan Mengambil data</option>');
                }
            })
        })

        $('#edit-pendukung').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ route('dashboard.relawan.pendukung.update', $pendukung->id) }}",
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
                }
            })
        })
    </script>
@endpush
