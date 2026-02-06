<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function profitRealtime()
{
    $data = DB::table('transaksi')
        ->selectRaw('MONTH(created_at) as bulan, SUM(total_harga) as total')
        ->where('status','paid')
        ->whereYear('created_at', now()->year)
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

    $labels = [];
    $values = [];

    foreach ($data as $row) {
        $labels[] = date('M', mktime(0, 0, 0, $row->bulan, 1));
        $values[] = (int) $row->total;
    }

    return response()->json([
        'labels' => $labels,
        'data' => $values
    ]);
}

public function chartTahunan(Request $request)
{
    $tahun = $request->tahun ?? now()->year;

    $data = DB::table('transaksi')
        ->selectRaw('MONTH(created_at) as bulan, SUM(total_harga) as total')
        ->where('status', 'paid')
        ->whereYear('created_at', $tahun)
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

    $labels = [];
    $values = [];

    for ($i = 1; $i <= 12; $i++) {
        $labels[] = date('M', mktime(0, 0, 0, $i, 1));
        $values[$i] = 0;
    }

    foreach ($data as $row) {
        $values[$row->bulan] = (int) $row->total;
    }

    return response()->json([
        'labels' => $labels,
        'values' => array_values($values),
    ]);
}

}
