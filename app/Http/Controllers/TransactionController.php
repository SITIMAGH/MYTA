<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('pages.transaksi.index', compact('products'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required',
            'total_price' => 'required',
            'kasir_id' => 'required|exists:users,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.total_price' => 'required|numeric'
        ]);

        // dd($request);

        // Using the get method to provide a default value of 'Tunai' if `payment_method` isn't provided
        $paymentMethod = $request->get('payment_method', 'Tunai');


        DB::beginTransaction();

        try {
            // Create the transaction record with the default payment method if not provided
            $transaction = new Transaction([
                'transaction_date' => $request->transaction_date,
                'total_price' => $request->total_price,
                'kasir_id' => $request->kasir_id,
                'payment_method' => $paymentMethod
            ]);

            // dd($transaction);

            $transaction->save();

            // Loop through each item and create a transaction item record
            foreach ($request->items as $item) {
                $transactionItem = new TransactionItem([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['total_price']
                ]);
                $transactionItem->save();

                // Find the product and decrement the stock
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->stock -= $item['quantity'];
                    $product->save();
                }
            }

            // Commit transaction
            DB::commit();
            return redirect()->route('transactions.index')->with('success', 'Transaction created successfully');
        } catch (\Exception $e) {
            // Rollback and return error if there is an exception
            DB::rollback();
            return back()->with('error', 'Error creating transaction: ' . $e->getMessage());
        }
    }
}
