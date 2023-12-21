@extends('layouts.main')

@section('title', 'Dashboard Relawan | Tambah pendukung')

@section('content')
  <x-sidebar />
  <div class="p-6 sm:ml-64">
    <div class="mb-8 flex items-center justify-between">
      <h1 class="text-3xl font-semibold">Tambah Pendukung</h1>
      <a href="{{ route('dashboard.relawan.pendukung') }}" class="rounded-lg bg-primary px-5 py-2.5 text-white transition-colors duration-200 hover:bg-blue-600 focus:outline-none">Back</a>
    </div>
    <form id="add-pendukung" class="mb-12 grid">
      @csrf
      <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
          <div class="flex flex-col gap-4">
              <div>
                  <label for="name" class="mb-2 block text-sm font-medium text-gray-900">Nama</label>
                  <input type="text" id="name" name="name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan nama pendukung " />
              </div>
              <div>
                  <label for="jenis_kelamin" class="mb-2 block text-sm font-medium text-gray-900">Jenis Kelamin</label>
                  <select id="jenis_kelamin" name="jenis_kelamin" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                      <option selected disabled>Pilih Jenis Kelamin</option>
                      <option value="L">Laki-Laki</option>
                      <option value="P">Perempuan</option>
                  </select>
              </div>
              <div>
                  <label for="usia" class="mb-2 block text-sm font-medium text-gray-900">Usia</label>
                  <input type="number" id="usia" name="usia" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan usia pendukung " />
              </div>
              <div>
                  <label for="kecamatan" class="mb-2 block text-sm font-medium text-gray-900">Kecamatan</label>
                  <select id="kecamatan" name="kec" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                      <option>Pilih Kecamatan</option>
                  </select>
              </div>
          </div>
          <div class="flex flex-col gap-4">
              <div>
                  <label for="desa" class="mb-2 block text-sm font-medium text-gray-900">Desa</label>
                  <select id="desa" name="desa" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                      <option>Pilih Desa</option>
                  </select>
              </div>
              <div>
                  <label for="rt" class="mb-2 block text-sm font-medium text-gray-900">RT</label>
                  <input type="number" id="rt" name="rt" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan RT pendukung, contoh: 1" />
              </div>
              <div>
                  <label for="rw" class="mb-2 block text-sm font-medium text-gray-900">RW</label>
                  <input type="number" id="rw" name="rw" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan RW pendukung, contoh: 1" />
              </div>
              <div>
                  <label for="tps" class="mb-2 block text-sm font-medium text-gray-900">TPS</label>
                  <input type="number" id="tps" name="tps_name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
              </div>
          </div>
      </div>
      <input type="hidden" id="user" name="user_id" value="{{ Auth::user()->id }}" />
      <div class="mt-8 flex justify-end gap-x-4">
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

        $('#add-pendukung').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('dashboard.relawan.pendukung.store-manual') }}",
                method: "POST",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(data) {
                  Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.message,
                    showConfirmButton: true
                  }).then(() => {
                    window.location.href = "{{ route('dashboard.relawan.pendukung') }}"
                  })
                },
                error: function(data) {
                  Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.responseJSON.message
                  })
                }
            })
        })
    </script>
@endpush