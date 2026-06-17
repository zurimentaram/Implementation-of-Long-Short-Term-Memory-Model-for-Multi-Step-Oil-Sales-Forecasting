<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PrediksiController extends Controller
{
    public function index()
    {
        $hasil = [];
        $file = storage_path('app/hasil_prediksi.json');

        if (file_exists($file)) {
            $hasil = json_decode(file_get_contents($file), true) ?? [];
        }

        return view('profile.prediksi', compact('hasil'));
    }

    public function proses()
{
    $penjualan = Penjualan::orderBy('periode')->get();

    $response = Http::post('http://127.0.0.1:5000/predict', [
        'penjualan' => $penjualan->toArray()
    ]);

    if (!$response->successful()) {
        return back()->with('error', 'Prediksi gagal dijalankan.');
    }

    $data = $response->json();

    file_put_contents(
        storage_path('app/hasil_prediksi.json'),
        json_encode($data, JSON_PRETTY_PRINT)
    );

    if (!file_exists(storage_path('app/hasil_prediksi.json'))) {
        return back()->with('error', 'File hasil_prediksi.json gagal dibuat.');
    }

    return redirect()->route('prediksi.index')->with('success', 'Prediksi berhasil diperbarui.');
    }

 }
