<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Data Penjualan
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" name="nama_produk" value="{{ old('nama_produk', $penjualan->nama_produk) }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Periode (Bulan/Tahun)</label>
                    <input type="month" name="periode" value="{{ old('periode', \Carbon\Carbon::parse($penjualan->periode)->format('Y-m')) }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Jumlah Penjualan</label>
                    <input type="number" name="jumlah_penjualan" value="{{ old('jumlah_penjualan', $penjualan->jumlah_penjualan) }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                           min="1">
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Update
                    </button>
                    <a href="{{ route('penjualan.index') }}"
                       class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>