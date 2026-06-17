@extends('layouts.dashboard')

@section('title', 'Data Penjualan')
@section('page_title', 'Data Penjualan')

@section('content')
<div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-semibold">Daftar Penjualan</h3>

    <div class="flex items-center gap-2">
        <form action="{{ route('penjualan.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex items-center gap-2">
                <input type="file" name="file" accept=".xlsx,.xls,.csv"
                       class="block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-semibold
                              file:bg-gray-100 file:text-gray-700
                              hover:file:bg-gray-200">
                <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Upload
                </button>
            </div>
        </form>

        <a href="{{ route('penjualan.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Tambah Data
        </a>

        <form action="{{ route('penjualan.clearAll') }}" method="POST"
              onsubmit="return confirm('Yakin ingin menghapus semua data?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Hapus Semua Data
            </button>
        </form>
        
    </div>
</div>

    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">Nama Produk</th>
                <th class="border px-4 py-2">Periode</th>
                <th class="border px-4 py-2">Jumlah Penjualan</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penjualan as $index => $item)
            <tr class="hover:bg-gray-50">
                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                <td class="border px-4 py-2">{{ $item->nama_produk }}</td>
                <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($item->periode)->format('F Y') }}</td>
                <td class="border px-4 py-2">{{ $item->jumlah_penjualan }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('penjualan.edit', $item->id) }}"
                       class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Edit</a>
                    <form action="{{ route('penjualan.destroy', $item->id) }}"
                          method="POST" class="inline"
                          onsubmit="return confirm('Yakin hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="border px-4 py-4 text-center text-gray-500">
                    Belum ada data penjualan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection