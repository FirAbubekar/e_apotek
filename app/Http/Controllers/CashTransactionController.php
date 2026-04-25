<?php

namespace App\Http\Controllers;

use App\Models\CashTransaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CashTransactionController extends Controller
{
    /**
     * Display a listing of Kas Masuk.
     */
    public function kasMasukIndex()
    {
        $transactions = CashTransaction::where('type', 'Masuk')
            ->with('user')
            ->orderBy('transaction_date', 'desc')
            ->paginate(10);

        $totalMasuk = CashTransaction::where('type', 'Masuk')->sum('amount');
        $masukBulanIni = CashTransaction::where('type', 'Masuk')
            ->whereMonth('transaction_date', date('m'))
            ->whereYear('transaction_date', date('Y'))
            ->sum('amount');

        return view('kasir.kas_masuk.index', compact('transactions', 'totalMasuk', 'masukBulanIni'));
    }

    /**
     * Show form for creating Kas Masuk.
     */
    public function kasMasukCreate()
    {
        $noTransaksi = $this->generateNoTransaksi('Masuk');
        return view('kasir.kas_masuk.create', compact('noTransaksi'));
    }

    /**
     * Store a newly created Kas Masuk.
     */
    public function kasMasukStore(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($request) {
                CashTransaction::create([
                    'no_transaksi' => $this->generateNoTransaksi('Masuk'),
                    'type' => 'Masuk',
                    'category' => $request->category,
                    'amount' => $request->amount,
                    'description' => $request->description,
                    'transaction_date' => $request->transaction_date,
                    'user_id' => Auth::id(),
                ]);
            });

            return redirect()->route('kas-masuk.index')->with('success', 'Kas Masuk berhasil dicatat');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mencatat Kas Masuk: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display a listing of Kas Keluar.
     */
    public function kasKeluarIndex()
    {
        $transactions = CashTransaction::where('type', 'Keluar')
            ->with('user')
            ->orderBy('transaction_date', 'desc')
            ->paginate(10);

        $totalKeluar = CashTransaction::where('type', 'Keluar')->sum('amount');
        $keluarBulanIni = CashTransaction::where('type', 'Keluar')
            ->whereMonth('transaction_date', date('m'))
            ->whereYear('transaction_date', date('Y'))
            ->sum('amount');

        return view('kasir.kas_keluar.index', compact('transactions', 'totalKeluar', 'keluarBulanIni'));
    }

    /**
     * Show form for creating Kas Keluar.
     */
    public function kasKeluarCreate()
    {
        $noTransaksi = $this->generateNoTransaksi('Keluar');
        return view('kasir.kas_keluar.create', compact('noTransaksi'));
    }

    /**
     * Store a newly created Kas Keluar.
     */
    public function kasKeluarStore(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($request) {
                CashTransaction::create([
                    'no_transaksi' => $this->generateNoTransaksi('Keluar'),
                    'type' => 'Keluar',
                    'category' => $request->category,
                    'amount' => $request->amount,
                    'description' => $request->description,
                    'transaction_date' => $request->transaction_date,
                    'user_id' => Auth::id(),
                ]);
            });

            return redirect()->route('kas-keluar.index')->with('success', 'Kas Keluar berhasil dicatat');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mencatat Kas Keluar: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show detail of Kas Keluar.
     */
    public function kasKeluarShow($id)
    {
        $transaction = CashTransaction::with('user')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $transaction->id,
                'no_transaksi' => $transaction->no_transaksi,
                'type' => $transaction->type,
                'category' => $transaction->category,
                'amount' => $transaction->amount,
                'amount_formatted' => number_format($transaction->amount, 0, ',', '.'),
                'description' => $transaction->description ?? '-',
                'date' => Carbon::parse($transaction->transaction_date)->format('d F Y'),
                'time' => Carbon::parse($transaction->transaction_date)->format('H:i'),
                'user' => $transaction->user->name ?? 'System',
                'print_url' => route('kas-keluar.print', $transaction->id)
            ]
        ]);
    }

    /**
     * Print Kas Keluar receipt.
     */
    public function kasKeluarPrint($id)
    {
        $transaction = CashTransaction::with('user')->findOrFail($id);
        $apotek = \App\Models\Apotik::first();
        
        return view('kasir.kas_keluar.print', compact('transaction', 'apotek'));
    }

    /**
     * Generate unique transaction number.
     */
    private function generateNoTransaksi($type)
    {
        $prefix = ($type == 'Masuk') ? 'KSM' : 'KSK';
        $date = date('Ymd');
        
        $lastTransaction = CashTransaction::where('no_transaksi', 'like', $prefix . '-' . $date . '-%')
            ->orderBy('no_transaksi', 'desc')
            ->first();

        if ($lastTransaction) {
            $lastNo = explode('-', $lastTransaction->no_transaksi);
            $sequence = intval(end($lastNo)) + 1;
        } else {
            $sequence = 1;
        }

        return $prefix . '-' . $date . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }
}
