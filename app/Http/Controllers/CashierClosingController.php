<?php

namespace App\Http\Controllers;

use App\Models\CashierClosing;
use App\Models\CashTransaction;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CashierClosingController extends Controller
{
    public function index()
    {
        $closings = CashierClosing::with('user')
            ->orderBy('closing_time', 'desc')
            ->paginate(10);

        return view('kasir.tutup_kasir.index', compact('closings'));
    }

    public function create()
    {
        $user = Auth::user();
        $lastClosing = CashierClosing::where('user_id', $user->id)
            ->orderBy('closing_time', 'desc')
            ->first();

        $openingTime = $lastClosing ? $lastClosing->closing_time : Carbon::today()->startOfDay();
        $openingCash = $lastClosing ? $lastClosing->actual_cash : 0; // Or get from a system setting

        // Calculate Stats since $openingTime
        $cashSales = Penjualan::where('user_id', $user->id)
            ->where('tanggal_penjualan', '>=', $openingTime)
            ->where('metode_pembayaran', 'Tunai')
            ->sum('total_harga');

        $nonCashSales = Penjualan::where('user_id', $user->id)
            ->where('tanggal_penjualan', '>=', $openingTime)
            ->where('metode_pembayaran', '!=', 'Tunai')
            ->sum('total_harga');

        $otherIncome = CashTransaction::where('user_id', $user->id)
            ->where('transaction_date', '>=', $openingTime)
            ->where('type', 'Masuk')
            ->where('category', '!=', 'Penjualan')
            ->sum('amount');

        $totalExpense = CashTransaction::where('user_id', $user->id)
            ->where('transaction_date', '>=', $openingTime)
            ->where('type', 'Keluar')
            ->sum('amount');

        $expectedCash = $openingCash + $cashSales + $otherIncome - $totalExpense;

        return view('kasir.tutup_kasir.create', compact(
            'openingTime', 'openingCash', 'cashSales', 'nonCashSales', 
            'otherIncome', 'totalExpense', 'expectedCash'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'opening_time' => 'required|date',
            'opening_cash' => 'required|numeric',
            'actual_cash' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $expectedCash = $request->expected_cash;
            $actualCash = $request->actual_cash;
            $difference = $actualCash - $expectedCash;

            CashierClosing::create([
                'user_id' => Auth::id(),
                'opening_time' => $request->opening_time,
                'closing_time' => now(),
                'opening_cash' => $request->opening_cash,
                'total_cash_sales' => $request->total_cash_sales,
                'total_non_cash_sales' => $request->total_non_cash_sales,
                'total_income' => $request->total_income,
                'total_expense' => $request->total_expense,
                'expected_cash' => $expectedCash,
                'actual_cash' => $actualCash,
                'difference' => $difference,
                'notes' => $request->notes,
            ]);

            DB::commit();
            return redirect()->route('tutup-kasir.index')->with('success', 'Kasir berhasil ditutup!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menutup kasir: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $closing = CashierClosing::with('user')->findOrFail($id);
        $apotek = \App\Models\Apotik::first();
        return view('kasir.tutup_kasir.show', compact('closing', 'apotek'));
    }
}
