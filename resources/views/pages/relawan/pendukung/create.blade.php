@extends('layouts.main')

@section('title', 'Dashboard Relawan | Tambah Pendukung')

@section('content')
    <x-sidebarRelawan />
    <div class="p-6 sm:ml-64">
      <div class="mb-8 flex items-center justify-between">
        <h1 class="text-3xl font-semibold">Tambah Pendukung</h1>
        <a href="{{ route('dashboard.relawan.index') }}" class="rounded-lg bg-primary px-5 py-2.5 text-white transition-colors duration-200 hover:bg-blue-600 focus:outline-none"  >Back</a >
      </div>
      <form id="add-pendukung" class="grid">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div class="w-full">
            <div class="mb-6">
              <label for="nik" class="block mb-2 text-sm font-medium text-gray-900">NIK</label>
              <input type="text" id="nik" name="nik" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukan NIK pendukung" />
            </div>
            <div class="mb-6">
              <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
              <input type="text" id="name" name="name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukan nama pendukung " />
            </div>
            <div class="mb-6">
              <label for="detail_alamat" class="block mb-2 text-sm font-medium text-gray-900">Detail Alamat</label>
              <textarea type="text" id="detail_alamat" name="detail_alamat" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukan Detail alamat "></textarea>
            </div>
          </div>
          <div class="w-full">
            <div class="mb-6">
              <label for="kecamatan" class="block mb-2 text-sm font-medium text-gray-900">Kecamatan</label>
              <select id="kecamatan" name="kec" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                <option>Pilih Kecamatan</option>
              </select>
              
            </div>
            <div class="mb-6">
              <label for="desa" class="block mb-2 text-sm font-medium text-gray-900">Desa</label>
              <select id="desa" name="desa" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                <option>Pilih Desa</option>
              </select>
            </div>
            <div class="mb-6">
              <label for="tps" class="block mb-2 text-sm font-medium text-gray-900">TPS</label>
              <select id="tps" name="tps_id" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                <option>Pilih TPS</option>
              </select>
            </div>
          </div>
        </div>
        <input type="hidden" id="user" name="user_id" value="{{ Auth::user()->id }}" />
        <button type="submit" class="w-full rounded-lg bg-primary px-5 py-2.5 text-center text-base font-medium text-white focus:ring-4 sm:w-auto">Tambah Pendukung</button>
      </form>
    </div>
@endsection

@push('script')
    <script>
      $(document).ready(function(){
        $.ajax({
          url: "{{ route('utility.area.district') }}",
          method: "GET",
          data : {
            id : 261
          },
          dataType: "JSON",
          success: function(data){
            $('#kecamatan').empty();
            $('#kecamatan').append('<option>Pilih Kecamatan</option>');
            $.each(data, function(key, value){
              $('#kecamatan').append('<option value="'+key+'">'+value+'</option>');
            })
          },
          error: function(data){
            $('#kecamatan').empty();
            $('#kecamatan').append('<option>Kesalahan Mengambil data</option>');
          }
        })
      })

      $(document).on('change', '#kecamatan', function(){
        var id = $(this).val();
        $.ajax({
          url: "{{ route('utility.area.sub-district') }}",
          method: "GET",
          data : {
            id : id
          },
          dataType: "JSON",
          success: function(data){
            $('#desa').empty();
            $('#desa').append('<option>Pilih Desa</option>');
            $.each(data, function(key, value){
              $('#desa').append('<option value="'+key+'">'+value+'</option>');
            })
          },
          error: function(data){
            $('#desa').empty();
            $('#desa').append('<option>Kesalahan Mengambil data</option>');
          }
        })
      })

      $(document).on('change', '#desa', function(){
        var id = $(this).val();
        $.ajax({
          url: "{{ route('utility.area.tps') }}",
          method: "GET",
          data : {
            id : id
          },
          dataType: "JSON",
          success: function(data){
            console.log(data)
            $('#tps').empty();
            $('#tps').append('<option>Pilih TPS</option>');
            $.each(data.message, function(key, value){
              $('#tps').append('<option value="'+value.id+'">'+value.name+'</option>');
            })
          },
          error: function(data){
            $('#tps').empty();
            $('#tps').append('<option>Kesalahan Mengambil data</option>');
          }
        })
      })

      $('#add-pendukung').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ route('dashboard.relawan.store') }}",
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
                        window.location.href = "{{ route('dashboard.relawan.index') }}"
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