<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();

        return view('pages.homepage.index', [
            'totalUsers' => $totalUsers,
            'totalProducts' => $totalProducts,
            'totalTransactions' => $totalTransactions,
        ]);
    }
}
