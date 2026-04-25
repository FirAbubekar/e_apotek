<?php

namespace App\Http\Controllers;

use App\Models\MedicineBatch;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExpiredMedicineController extends Controller
{
    /**
     * Display a listing of expiring and expired medicines.
     */
    public function index()
    {
        $today = Carbon::now();
        $threeMonths = Carbon::now()->addMonths(3);
        $sixMonths = Carbon::now()->addMonths(6);

        // 1. Sudah Expired (Merah)
        $expired = $this->getBatchesByDate(null, $today);

        // 2. Kritis / Hampir Expired < 3 Bulan (Oranye)
        $critical = $this->getBatchesByDate($today, $threeMonths);

        // 3. Monitor / < 6 Bulan (Kuning)
        $monitor = $this->getBatchesByDate($threeMonths, $sixMonths);

        return view('master.obat_expired.index', compact('expired', 'critical', 'monitor'));
    }

    /**
     * Helper to get batches with stock joined
     */
    private function getBatchesByDate($startDate, $endDate)
    {
        $query = DB::table('medicine_batches')
            ->join('medicines', 'medicine_batches.medicine_id', '=', 'medicines.id')
            ->join('medicine_stocks', 'medicine_batches.id', '=', 'medicine_stocks.batch_id')
            ->leftJoin('suppliers', 'medicine_batches.pembelian_id', '=', 'suppliers.id') // This might be wrong depending on FB structure, but let's try
            ->select(
                'medicines.medicine_name',
                'medicine_batches.id',
                'medicine_batches.batch_number',
                'medicine_batches.expired_date',
                'medicine_stocks.last_stock',
                'medicine_stocks.id as stock_id'
            )
            ->where('medicine_stocks.last_stock', '>', 0);

        if ($startDate) {
            $query->where('medicine_batches.expired_date', '>', $startDate->format('Y-m-d'));
        }

        if ($endDate) {
            $query->where('medicine_batches.expired_date', '<=', $endDate->format('Y-m-d'));
        }

        return $query->orderBy('medicine_batches.expired_date', 'asc')->get();
    }
}
