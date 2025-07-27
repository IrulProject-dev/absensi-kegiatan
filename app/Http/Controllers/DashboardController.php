<?php

namespace App\Http\Controllers;

use App\Models\Prasence;
use App\Models\PrasenceDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung statistik
        $totalKegiatan = Prasence::where('user_id', auth()->id())->count();
        $totalPeserta = PrasenceDetail::whereHas('prasence', function($query) {
            $query->where('user_id', auth()->id());
        })->count();

        $kegiatanHariIni = Prasence::where('user_id', auth()->id())
            ->whereDate('tgl_kegiatan', today())
            ->count();

        $pesertaHariIni = PrasenceDetail::whereHas('prasence', function($query) {
            $query->where('user_id', auth()->id())
                  ->whereDate('tgl_kegiatan', today());
        })->count();

        // Ambil data untuk tabel
        $kegiatanTerbaru = Prasence::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $pesertaTerbaru = PrasenceDetail::whereHas('prasence', function($query) {
            $query->where('user_id', auth()->id());
        })
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

        // Data untuk chart
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $chartLabels = [];
        $chartData = [];

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $chartLabels[] = $date->format('d M');

            $count = PrasenceDetail::whereHas('prasence', function($query) use ($date) {
                $query->where('user_id', auth()->id())
                      ->whereDate('tgl_kegiatan', $date);
            })->count();

            $chartData[] = $count;
        }

        return view('dashboard', compact(
            'totalKegiatan',
            'totalPeserta',
            'kegiatanHariIni',
            'pesertaHariIni',
            'kegiatanTerbaru',
            'pesertaTerbaru',
            'chartLabels',
            'chartData'
        ));
    }
}
