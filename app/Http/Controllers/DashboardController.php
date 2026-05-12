<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        $today = Carbon::today();

        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_transactions' => Transaction::count(),
            'revenue_today' => Transaction::whereDate('created_at', $today)->sum('total'),
        ];

        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();

        // Chart data for 7 days
        $dates = [];
        $transactionData = [];
        $revenueData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dates[] = $date->format('M d');
            $transactionData[] = Transaction::whereDate('created_at', $date)->count();
            $revenueData[] = Transaction::whereDate('created_at', $date)->sum('total');
        }

        return view('dashboard-admin', compact('stats', 'recentTransactions', 'dates', 'transactionData', 'revenueData'));
    }

    public function kasir()
    {
        $today = Carbon::today();

        $stats = [
            'transactions_today' => Transaction::whereDate('created_at', $today)->count(),
            'revenue_today' => Transaction::whereDate('created_at', $today)->sum('total'),
            'items_sold_today' => TransactionItem::whereHas('transaction', function($q) use ($today) {
                $q->whereDate('created_at', $today);
            })->sum('qty'),
        ];

        $todayTransactions = Transaction::with('user')->whereDate('created_at', $today)->latest()->take(5)->get();

        return view('dashboard-kasir', compact('stats', 'todayTransactions'));
    }
}