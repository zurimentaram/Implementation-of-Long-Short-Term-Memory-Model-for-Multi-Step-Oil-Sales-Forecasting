@extends('layouts.dashboard')

@section('title', 'Evaluasi')
@section('page_title', 'Evaluasi')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h1 class="text-xl font-bold mb-4">Halaman Evaluasi</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="p-4 bg-gray-100 rounded">
            <p class="text-gray-600">MAE</p>
            <p class="text-2xl font-bold">{{ $mae ?? '-' }}</p>
        </div>

        <div class="p-4 bg-gray-100 rounded">
            <p class="text-gray-600">RMSE</p>
            <p class="text-2xl font-bold">{{ $rmse ?? '-' }}</p>
        </div>

        <div class="p-4 bg-gray-100 rounded">
            <p class="text-gray-600">MAPE</p>
            <p class="text-2xl font-bold">{{ $mape ?? '-' }}</p>
        </div>
    </div>
</div>
@endsection