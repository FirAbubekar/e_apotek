<?php

namespace App\Http\Controllers;

use App\Models\StockMutation;
use Illuminate\Http\Request;

class StockMutationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = StockMutation::with(['medicineStock.obat', 'medicineStock.batch', 'user'])
            ->latest();

        // Optional filtering by type
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // Optional filtering by medicine name
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('medicineStock.obat', function($q) use ($search) {
                $q->where('medicine_name', 'like', "%{$search}%");
            })->orWhere('reference', 'like', "%{$search}%");
        }

        $mutations = $query->paginate(20);

        return view('master.stock_mutation.index', compact('mutations'));
    }
}
