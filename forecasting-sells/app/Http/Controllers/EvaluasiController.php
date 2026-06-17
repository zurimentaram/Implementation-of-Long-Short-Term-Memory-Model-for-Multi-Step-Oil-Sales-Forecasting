<?php

namespace App\Http\Controllers;

class EvaluasiController extends Controller
{
    public function index()
    {
        $path = storage_path('app/evaluation_result.json');

    //      dd([
    //     'path' => $path,
    //     'exists' => file_exists($path),
    // ]);

        $data = [
            'mae' => null,
            'rmse' => null,
            'mape' => null,
        ];

        if (file_exists($path)) {
            $json = json_decode(file_get_contents($path), true);

            $data['mae'] = $json['mae'] ?? null;
            $data['rmse'] = $json['rmse'] ?? null;
            $data['mape'] = $json['mape'] ?? null;
        }

        return view('profile.evaluasi', $data);
    }
}