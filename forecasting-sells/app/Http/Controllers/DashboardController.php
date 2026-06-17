<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; // Ditambahkan untuk manipulasi berkas fisik
use Illuminate\Support\Facades\Artisan; // Ditambahkan jika menggunakan cache Laravel

class DashboardController extends Controller
{
    public function index()
{
    $penjualan = Penjualan::orderBy('id')->get();
    $totalData = $penjualan->count();

    $hasil = [];
    $file = storage_path('app/hasil_prediksi.json');

    if (file_exists($file)) {
        $hasil = json_decode(file_get_contents($file), true) ?? [];
    }

    $eval = ['mae' => '-', 'rmse' => '-', 'mape' => '-'];
    $evalFile = storage_path('app/evaluation_result.json');

    if (file_exists($evalFile)) {
        $eval = json_decode(file_get_contents($evalFile), true) ?? $eval;
    }

    return view('profile.dashboard', [
        'totalData' => $totalData,
        'prediksiTerakhir' => $hasil['prediksi_terakhir'] ?? '-',
        'prediksi' => $hasil['prediksi'] ?? [],
        'mae' => $eval['mae'] ?? '-',
        'rmse' => $eval['rmse'] ?? '-',
        'mape' => $eval['mape'] ?? '-',
    ]);
}
}