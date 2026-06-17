@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')

<div class="mt-6 bg-white p-4 rounded shadow">
    <h2 class="text-lg font-semibold mb-3">Grafik Aktual vs Prediksi</h2>
    <img src="{{ asset('images/grafik_aktual_vs_prediksi.png') }}" alt="Grafik Aktual vs Prediksi" class="w-full">
</div>

<div class="grid grid-cols-1 md:grid-cols-5 gap-4">
    <div class="p-4 bg-white rounded shadow">
        <p class="text-gray-500">Total Data Penjualan</p>
        <p class="text-2xl font-bold">{{ $totalData }}</p>
    </div>

    <div class="p-4 bg-white rounded shadow">
        <p class="text-gray-500">Prediksi Terakhir</p>
        <p class="text-2xl font-bold">{{ $prediksiTerakhir }}</p>
    </div>

    <div class="p-4 bg-white rounded shadow">
        <p class="text-gray-500">MAE</p>
        <p class="text-2xl font-bold">{{ $mae }}</p>
    </div>

    <div class="p-4 bg-white rounded shadow">
        <p class="text-gray-500">RMSE</p>
        <p class="text-2xl font-bold">{{ $rmse }}</p>
    </div>

    <div class="p-4 bg-white rounded shadow">
        <p class="text-gray-500">MAPE</p>
        <p class="text-2xl font-bold">{{ $mape }}</p>
    </div>
</div>

@if(!empty($prediksi))
<div class="mt-6 bg-white p-4 rounded shadow">
    <h2 class="text-lg font-semibold mb-3">Prediksi Multi-step</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($prediksi as $item)
            <div class="p-4 bg-gray-100 rounded">
                <p class="text-gray-600">{{ $item['periode'] }}</p>
                <p class="text-2xl font-bold">{{ number_format($item['prediksi_penjualan'], 2) }}</p>
            </div>
        @endforeach
    </div>
</div>
@endif
@endsection