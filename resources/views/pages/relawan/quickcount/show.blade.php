@extends('layouts.main')

@section('title', 'Quickcount | Dashboard Relawan')
@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
      <div class="mb-8 flex items-center justify-between">
        <h1 class="text-3xl font-semibold">Quickcount</h1>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('dashboard.quickcount.index') }}" class="rounded-lg bg-red-700 px-5 py-2.5 text-white transition-colors duration-200 hover:bg-red-900 focus:outline-none"  >Back</a >
        </div>
      </div>
      <div class="mb-8">
        <form id="add-quickcount" class="mb-12 grid">
          @csrf
          <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
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
                </div>
                <div class="flex flex-col gap-4">
                  <div>
                    <label for="tps" class="mb-2 block text-sm font-medium text-gray-900">TPS</label>
                    <select id="tps" name="tps_id" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                        <option>Pilih TPS</option>
                    </select>
                  </div>
                  <div>
                      <label for="total" class="mb-2 block text-sm font-medium text-gray-900">Total Suara Sah</label>
                      <input type="number" placeholder="Masukkan Total" id="total" name="total" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                  </div>

              </div>
          </div>
          <input type="hidden" id="user" name="candidate_id" value="{{$id}}" />
          <div class="mt-8 flex justify-center gap-x-4">
              <button type="submit" class="rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white transition-colors duration-300 hover:bg-blue-800 focus:outline-none">Tambah Pendukung</button>
          </div>
        </form>
      </div>
      <div class="my-8">
        <h3 class="text-2xl" >Profil Caleg Pemilu 2024</h3>
        <div class="grid grid-cols-1 md:grid-cols-2">
          <img src="{{ asset('storage/candidate/'. $profile->image) }}" class="m-6 rounded-2xl" alt="profil" width="300" height="500" />
          <div class="mt-12">
            <h3 class="text-2xl" > Nama Lengkap : {{$profile->name}}</h3>
            <p class="text-lg" >Partai Pengusung :{{$profile->partai}}</p>
            <p class="text-lg" >Jenis Kelamin : {{$profile->jenis_kelamin}}</p>
            <p class="text-lg" >Nomor Urut : {{$profile->nomor_urut}}</p>
            <h3 class="text-xl" >Jumlah Suara terbaru : {{$vote}}</h3>
          </div>
        </div>
      </div>
      <div class="flex flex-col items-start mb-12 justify-between gap-y-3 md:flex-row md:items-center">
        <div class="flex items-center gap-x-4">
            <p class="flex-grow text-sm">Show per page(s):</p>
            <select id="showPerPages" class="rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                <option value="10">10</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="relative flex-shrink self-stretch">
            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                <i class='bx bx-search text-xl text-gray-500'></i>
            </div>
            <input type="search" id="search" name="search" class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Cari data disini...">
        </div>
    </div>
    <div class="relative overflow-x-auto sm:rounded-lg">
        <table id="relawan" class="w-full text-left text-sm text-gray-500 rtl:text-right">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Desa
                    </th>
                    <th scope="col" class="px-6 py-3">
                        TPS
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Suara Sah
                    </th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div id="pagination" class="mt-4"></div>
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

        $('#add-quickcount').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('dashboard.quickcount.store') }}",
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
                    window.location.href = "{{ route('dashboard.quickcount.index') }}"
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
