@extends('layouts.main')

@section('title', 'Dashboard Admin | Dashboard')

@section('content')
    <x-sidebar />
    <div class="p-6 sm:ml-64">
        @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800" role="alert">
                    <span class="font-medium">{{ session('success') }}!</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800" role="alert">
                    <span class="font-medium">{{ session('error') }}!</span>
                </div>
            @endif
      <div class="mb-8 flex items-center justify-between">
        <h1 class="text-3xl font-semibold">List Candidate</h1>
        <a href="{{ route('dashboard.candidate.create') }}" class="rounded-lg bg-primary px-5 py-2.5 text-white transition-colors duration-200 hover:bg-blue-600 focus:outline-none"  >Tambah Candidate</a >
      </div>
      <div class="relative overflow-x-auto sm:rounded-lg">
        <table id="relawan" class="w-full text-left text-sm text-gray-500 rtl:text-right">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No urut
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Pass Foto
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama Lengkap Candidate
                    </th>
                    <th scope="col" class="px-6 py-3">
                        jenis Kelamin 
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Partai
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tempat Tinggal
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($candidates as $candidate)
                    <tr class="border-b odd:bg-white even:bg-gray-50">
                        <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                            {{ $candidate->nomor_urut }}
                        </th>
                        <td class="px-6 py-4">
                            <img src="{{ asset('storage/candidate' . $candidate->photo) }}" alt="{{ $candidate->name }}" class="w-20 object-cover">
                        </td>
                        <td class="px-6 py-4">
                            {{ $candidate->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $candidate->jenis_kelamin }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $candidate->partai }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $candidate->tempat_tinggal }}
                        </td>
                        <td class="px-6 py-4 flex gap-4">
                          <a  href="{{ route('dashboard.candidate.edit', $candidate->id) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                          <a  href="{{ route('dashboard.candidate.show', $candidate->id) }}" class="font-medium text-green-600 hover:underline">Detail</a>
                          <button onclick="{handleDelete('{{ $candidate->id }}')}" class="font-medium text-red-600 hover:underline">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-500">
                            Tidak ada data yang dapat ditampilkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
      </div>
      <div class="mt-4">
          {{-- {{ $pendukung->links('pagination::tailwind') }} --}}
      </div>
    </div>
@endsection

@push('script')
    <script>
        function handleDelete(id) {
            swal({
                title: 'Apakah anda?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'DELETE',
                        url: "{{ route('dashboard.candidate.destroy', ':id') }}".replace(':id', id),
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            id: id,
                        },
                        success: function(response) {
                            swal(
                                'Deleted!',
                                response.message,
                            ).then(() => {
                                window.location.reload()
                            })
                        },
                        error: function(response) {
                            swal({
                                title: "Error",
                                text: response.message,
                            })
                        }
                    })

                }
            })
        }
    </script>
@endpush