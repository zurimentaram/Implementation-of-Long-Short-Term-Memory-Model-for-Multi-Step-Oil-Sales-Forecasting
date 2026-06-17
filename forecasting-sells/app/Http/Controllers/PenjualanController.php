<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Imports\PenjualanImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::orderBy('periode', 'desc')->get();
        return view('penjualan.index', compact('penjualan'));
    }

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv|max:2048',
    ]);

    Excel::import(new PenjualanImport, $request->file('file'));

    return back()->with('success', 'Data berhasil diimport');
}

    public function create()
    {
        return view('penjualan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk'      => 'required|string',
            'periode'          => 'required|date',
            'jumlah_penjualan' => 'required|integer|min:1',
        ]);

        Penjualan::create($request->only('nama_produk', 'periode', 'jumlah_penjualan'));

        return redirect()->route('penjualan.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit(Penjualan $penjualan)
    {
        return view('penjualan.edit', compact('penjualan'));
    }

    public function update(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'nama_produk'      => 'required|string',
            'periode'          => 'required|date',
            'jumlah_penjualan' => 'required|integer|min:1',
        ]);

        $penjualan->update($request->only('nama_produk', 'periode', 'jumlah_penjualan'));

        return redirect()->route('penjualan.index')->with('success', 'Data berhasil diupdate!');
    }

    public function show(Penjualan $penjualan)
{
    return view('penjualan.show', compact('penjualan'));
}

    public function destroy(Penjualan $penjualan)
    {
        $penjualan->delete();
        return redirect()->route('penjualan.index')->with('success', 'Data berhasil dihapus!');
    }

    public function clearAll()
    {
    DB::table('penjualan')->delete();

    $predFile = base_path('../python-ml/hasil_prediksi_multistep.csv');
    $plotFile = public_path('images/grafik_aktual_vs_prediksi.png');

    if (File::exists($predFile)) {
        File::delete($predFile);
    }

    if (File::exists($plotFile)) {
        File::delete($plotFile);
    }

    return redirect()->back()->with('success', 'Semua data berhasil dihapus.');
    }


}