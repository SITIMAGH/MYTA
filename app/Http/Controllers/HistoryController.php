<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        // $transactions = \App\Models\Transaction::with('kasir')->orderBy('created_at', 'desc')->paginate(10);
        $query = \App\Models\Transaction::with('kasir')->orderBy('transaction_date', 'desc');

        // Check if start and end date filters are provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            // Assuming 'transaction_date' is a DATE field (not DATETIME)
            $query->where('transaction_date', '>=', $startDate)
                ->where('transaction_date', '<=', $endDate);
        }

        // Additional filtering by month and year
        if ($request->filled('month') && $request->filled('year')) {
            $month = $request->month;
            $year = $request->year;

            $query->whereMonth('transaction_date', '=', $month)
                ->whereYear('transaction_date', '=', $year);
        } elseif ($request->filled('month')) {
            $query->whereMonth('transaction_date', '=', $request->month);
        } elseif ($request->filled('year')) {
            $query->whereYear('transaction_date', '=', $request->year);
        }

        $transactions = $query->paginate(10);

        return view('pages.history.index', compact('transactions'));
    }

    public function show($id)
    {
        $transactions = \App\Models\Transaction::with('kasir',)->findOrFail($id);

        // data transactions items
        $transactionItems = \App\Models\TransactionItem::with('product')->where('transaction_id', $id)->get();

        return view('pages.history.view', compact('transactions', 'transactionItems'));
    }

    public function exportHistoryAll(Request $request)
    {
        $query = \App\Models\Transaction::query();

        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('transaction_date', '=', $request->month)
                ->whereYear('transaction_date', '=', $request->year);
        } elseif ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
        }

        $historyAll = $query->get();
        $pdf = PDF::loadView('pages.history.historyTransactionsAllPDF', compact('historyAll'));
        return $pdf->download('historyAll.pdf');
    }
}
