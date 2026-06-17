@extends('layouts.dashboard')

@section('title', 'Prediksi')
@section('page_title', 'Prediksi')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h1 class="text-xl font-bold mb-4">Halaman Prediksi</h1>

    <form action="{{ route('prediksi.proses') }}" method="POST">
        @csrf
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
            Jalankan Prediksi
        </button>
    </form>

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        {{ session('error') }}
    </div>
@endif

    @if(!empty($hasil['prediksi']) && is_array($hasil['prediksi']))
    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-left">No</th>
                    <th class="border px-4 py-2 text-left">Periode</th>
                    <th class="border px-4 py-2 text-left">Prediksi Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasil['prediksi'] as $index => $item)
                    <tr>
                        <td class="border px-4 py-2">{{ $index + 1 }}</td>
                        <td class="border px-4 py-2">{{ $item['periode'] ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $item['prediksi_penjualan'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

    @if(isset($hasil['prediksi_terakhir']))
        <div class="mt-6">
            <p><strong>Prediksi Terakhir:</strong> {{ $hasil['prediksi_terakhir'] }}</p>
        </div>
    @endif
</div>
@endsection