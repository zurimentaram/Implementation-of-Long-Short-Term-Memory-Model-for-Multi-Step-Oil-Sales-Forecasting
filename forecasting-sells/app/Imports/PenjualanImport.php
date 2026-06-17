<?php

namespace App\Imports;

use App\Models\Penjualan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class PenjualanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $periode = $row['periode'] ?? null;

        if (!$periode) {
            return null;
        }

        if (is_numeric($periode)) {
            $periode = ExcelDate::excelToDateTimeObject($periode);
            $periode = Carbon::instance($periode)->startOfMonth()->format('Y-m-d');
        } else {
            $periode = Carbon::parse($periode)->startOfMonth()->format('Y-m-d');
        }

        return new Penjualan([
            'nama_produk' => $row['nama_produk'],
            'periode' => $periode,
            'jumlah_penjualan' => $row['jumlah_penjualan'],
        ]);
    }
}