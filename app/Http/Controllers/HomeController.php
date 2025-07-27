<?php

namespace App\Http\Controllers;

use App\Models\prasence;
use App\Models\prasenceDetail;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Hitung statistik
        $totalKegiatan = prasence::where('user_id', auth()->id())->count();
        $totalPeserta = prasenceDetail::whereHas('prasence', function($query) {
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
        $chartActivitiesData = [];

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $chartLabels[] = $date->format('d M');

            $participantsCount = PrasenceDetail::whereHas('prasence', function($query) use ($date) {
                $query->where('user_id', auth()->id())
                      ->whereDate('tgl_kegiatan', $date);
            })->count();

            $activitiesCount = Prasence::where('user_id', auth()->id())
                ->whereDate('tgl_kegiatan', $date)
                ->count();

            $chartData[] = $participantsCount;
            $chartActivitiesData[] = $activitiesCount;
        }

        return view('home', compact(
            'totalKegiatan',
            'totalPeserta',
            'kegiatanHariIni',
            'pesertaHariIni',
            'kegiatanTerbaru',
            'pesertaTerbaru',
            'chartLabels',
            'chartData',
            'chartActivitiesData'
        ));
    }
}
