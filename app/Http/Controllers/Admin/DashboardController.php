<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic stats
        $totalPeserta = Peserta::count();
        $lastMonthPeserta = Peserta::where('created_at', '>=', Carbon::now()->subMonth())->count();

        // Jersey inventory
        $jerseyInventory = Size::select('sizes.name', 'sizes.stock', DB::raw('COALESCE(COUNT(peserta.id), 0) as used'))
            ->leftJoin('peserta', 'sizes.id', '=', 'peserta.size_id')
            ->groupBy('sizes.id', 'sizes.name', 'sizes.stock')
            ->orderBy('sizes.name')
            ->get()
            ->map(function ($size) {
                return [
                    'size' => $size->name,
                    'stock' => $size->stock ?: 0,
                    'used' => $size->used ?: 0,
                    'remaining' => max(0, ($size->stock ?: 0) - ($size->used ?: 0))
                ];
            });

        // Participant Categories Distribution
        $categoryDistribution = Peserta::select('kategori', DB::raw('count(*) as total'))
            ->whereNotNull('kategori')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        // Age distribution
        $ageGroups = Peserta::select(
            DB::raw('
                CASE 
                    WHEN usia < 20 THEN "Under 20"
                    WHEN usia BETWEEN 20 AND 29 THEN "20-29"
                    WHEN usia BETWEEN 30 AND 39 THEN "30-39"
                    WHEN usia BETWEEN 40 AND 49 THEN "40-49"
                    ELSE "50+"
                END as age_group
            '),
            DB::raw('count(*) as total'),
            DB::raw('AVG(usia) as avg_age'),
            DB::raw('MIN(usia) as min_age'),
            DB::raw('MAX(usia) as max_age')
        )
            ->whereNotNull('usia')
            ->groupBy('age_group')
            ->orderBy(DB::raw('MIN(usia)'))
            ->get();

        // Registration trends 
        $registrationTrends = Peserta::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Geographic distribution
        $provincesDistribution = Peserta::select('provinsi', DB::raw('count(*) as total'))
            ->whereNotNull('provinsi')
            ->groupBy('provinsi')
            ->orderByDesc('total')
            ->get();

        $citiesDistribution = Peserta::select('kota', DB::raw('count(*) as total'))
            ->whereNotNull('kota')
            ->groupBy('kota')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Payment stats
        $totalPaid = Peserta::where('status_pembayaran', 'paid')->count();
        $totalPending = Peserta::where('status_pembayaran', 'pending')->count();

        $paymentMethodStats = Peserta::where('status_pembayaran', 'paid')
            ->whereNotNull('midtrans_payment_type')
            ->select('midtrans_payment_type', DB::raw('count(*) as total'))
            ->groupBy('midtrans_payment_type')
            ->orderByDesc('total')
            ->get();

        // Blood type distribution
        $bloodTypes = Peserta::select('golongan_darah', DB::raw('count(*) as total'))
            ->whereNotNull('golongan_darah')
            ->groupBy('golongan_darah')
            ->orderByDesc('total')
            ->get();

        // Medical stats
        $medicalStats = [
            'with_allergies' => Peserta::where('ada_alergi', true)->count(),
            'without_allergies' => Peserta::where('ada_alergi', false)->count(),
            'with_medical_history' => Peserta::whereNotNull('riwayat_penyakit')->count()
        ];

        // Check-in stats
        $checkInStats = [
            'total_checked_in' => Peserta::where('is_checked_in', true)->count(),
            'check_in_by_hour' => Peserta::where('is_checked_in', true)
                ->whereNotNull('check_in_time')
                ->select(DB::raw('HOUR(check_in_time) as hour'), DB::raw('count(*) as total'))
                ->groupBy('hour')
                ->orderBy('hour')
                ->get()
        ];

        return view('admin.dashboard', compact(
            'totalPeserta',
            'lastMonthPeserta',
            'jerseyInventory',
            'categoryDistribution',
            'ageGroups',
            'registrationTrends',
            'provincesDistribution',
            'citiesDistribution',
            'totalPaid',
            'totalPending',
            'paymentMethodStats',
            'bloodTypes',
            'medicalStats',
            'checkInStats'
        ));
    }
}