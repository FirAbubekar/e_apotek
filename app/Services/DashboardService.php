<?php

namespace App\Services;

use App\Models\Obat;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardService
{
    /**
     * Get aggregate statistics for the top dashboard cards
     */
    public function getDashboardStats(): array
    {
        $totalMedicines = Obat::count();
        $totalCustomers = Customer::count();
        $totalSuppliers = Supplier::count();

        // Count medicines where current stock <= minimum_stock
        $lowStockCount = $this->getLowStockMedicines()->count();

        // In a real app, sales/revenue would be queried from sales table
        // For now we mock the transaction count since sales module isn't fully built yet
        $transactionsToday = 0; 
        $revenueToday = 0;

        return [
            'total_medicines' => $totalMedicines,
            'total_customers' => $totalCustomers,
            'total_suppliers' => $totalSuppliers,
            'low_stock_count' => $lowStockCount,
            'transactions_today' => $transactionsToday,
            'revenue_today' => $revenueToday,
        ];
    }

    /**
     * Get list of medicines that have dropped below their minimum stock threshold.
     */
    public function getLowStockMedicines()
    {
        // We join medicines with the SUM of their current stock from medicine_stocks
        return Obat::select('medicines.id', 'medicines.medicine_name', 'medicines.minimum_stock', DB::raw('COALESCE(SUM(medicine_stocks.last_stock), 0) as current_stock'))
            ->leftJoin('medicine_stocks', 'medicines.id', '=', 'medicine_stocks.medicine_id')
            ->groupBy('medicines.id', 'medicines.medicine_name', 'medicines.minimum_stock')
            ->havingRaw('current_stock <= medicines.minimum_stock')
            ->orderBy('current_stock', 'asc')
            ->get();
    }

    /**
     * Get list of medicine batches expiring within the next 3 months, or already expired.
     */
    public function getExpiringBatches()
    {
        $threeMonthsFromNow = Carbon::now()->addMonths(3)->format('Y-m-d');

        return DB::table('medicine_batches')
            ->join('medicines', 'medicine_batches.medicine_id', '=', 'medicines.id')
            ->join('medicine_stocks', 'medicine_batches.id', '=', 'medicine_stocks.batch_id')
            ->select(
                'medicines.medicine_name',
                'medicine_batches.batch_number',
                'medicine_batches.expired_date',
                'medicine_stocks.last_stock as current_stock'
            )
            ->where('medicine_batches.expired_date', '<=', $threeMonthsFromNow)
            ->where('medicine_stocks.last_stock', '>', 0) // Only alert if we actually still have it in stock
            ->orderBy('medicine_batches.expired_date', 'asc')
            ->limit(10)
            ->get();
    }
}
