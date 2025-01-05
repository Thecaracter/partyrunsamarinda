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
        // Basic stats (hanya yang paid)
        $totalPeserta = Peserta::where('status_pembayaran', 'paid')->count();

        // Jersey inventory (hanya yang paid)
        $jerseyInventory = Size::select(
            'sizes.id',
            'sizes.name',
            'sizes.stock',
            DB::raw('(
               SELECT COUNT(*) 
               FROM peserta 
               WHERE peserta.size_id = sizes.id 
               AND peserta.deleted_at IS NULL
               AND peserta.status_pembayaran = "paid"
           ) as used')
        )
            ->orderBy('sizes.name')
            ->get()
            ->map(function ($size) {
                return [
                    'size' => $size->name,
                    'total_stock' => $size->stock + $size->used, // Total stok awal
                    'used' => $size->used, // Terjual (paid)
                    'remaining' => $size->stock // Stok yang tersisa
                ];
            });

        // Participant Categories Distribution (hanya yang paid)
        $categoryDistribution = Peserta::select('kategori', DB::raw('count(*) as total'))
            ->where('status_pembayaran', 'paid')
            ->whereNotNull('kategori')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        // Age distribution (hanya yang paid)
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
            ->where('status_pembayaran', 'paid')
            ->whereNotNull('usia')
            ->groupBy('age_group')
            ->orderBy(DB::raw('MIN(usia)'))
            ->get();

        // Registration trends (paid only)
        $registrationTrends = Peserta::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as total')
        )
            ->where('status_pembayaran', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Geographic distribution (paid only)
        $provincesDistribution = Peserta::select('provinsi', DB::raw('count(*) as total'))
            ->where('status_pembayaran', 'paid')
            ->whereNotNull('provinsi')
            ->groupBy('provinsi')
            ->orderByDesc('total')
            ->get();

        // Payment Method Stats (hanya yang paid)
        $paymentMethodStats = Peserta::where('status_pembayaran', 'paid')
            ->whereNotNull('midtrans_payment_type')
            ->select('midtrans_payment_type', DB::raw('count(*) as total'))
            ->groupBy('midtrans_payment_type')
            ->orderByDesc('total')
            ->get();

        // Blood type distribution (paid only)
        $bloodTypes = Peserta::select('golongan_darah', DB::raw('count(*) as total'))
            ->where('status_pembayaran', 'paid')
            ->whereNotNull('golongan_darah')
            ->groupBy('golongan_darah')
            ->orderByDesc('total')
            ->get();

        // Medical stats (paid only)
        $medicalStats = [
            'with_allergies' => Peserta::where('status_pembayaran', 'paid')->where('ada_alergi', true)->count(),
            'without_allergies' => Peserta::where('status_pembayaran', 'paid')->where('ada_alergi', false)->count(),
            'with_medical_history' => Peserta::where('status_pembayaran', 'paid')->whereNotNull('riwayat_penyakit')->count()
        ];

        // Check-in stats (hanya yang paid)
        $checkInStats = [
            'total_checked_in' => Peserta::where('status_pembayaran', 'paid')->where('is_checked_in', true)->count(),
            'check_in_by_hour' => Peserta::where('status_pembayaran', 'paid')
                ->where('is_checked_in', true)
                ->whereNotNull('check_in_time')
                ->select(DB::raw('HOUR(check_in_time) as hour'), DB::raw('count(*) as total'))
                ->groupBy('hour')
                ->orderBy('hour')
                ->get()
        ];

        return view('admin.dashboard', compact(
            'totalPeserta',
            'jerseyInventory',
            'categoryDistribution',
            'ageGroups',
            'registrationTrends',
            'provincesDistribution',
            'paymentMethodStats',
            'bloodTypes',
            'medicalStats',
            'checkInStats'
        ));
    }
}