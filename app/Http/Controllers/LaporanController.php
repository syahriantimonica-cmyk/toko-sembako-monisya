<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'items.product']);

        // Filter berdasarkan tanggal
        if ($request->has('filter') && $request->filter == 'harian') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($request->has('filter') && $request->filter == 'bulanan') {
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
        }

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_transaksi', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('laporan.index', compact('transactions'));
    }

    public function detail($id)
    {
        $transaction = Transaction::with(['user', 'items.product'])->findOrFail($id);

        return view('laporan.detail', compact('transaction'));
    }

    public function exportPdf(Request $request)
    {
        $query = Transaction::with(['user', 'items.product']);

        // Filter berdasarkan tanggal
        if ($request->has('filter') && $request->filter == 'harian') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($request->has('filter') && $request->filter == 'bulanan') {
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        $totalPendapatan = $transactions->sum('total');

        $pdf = Pdf::loadView('laporan.pdf', compact('transactions', 'totalPendapatan'));

        return $pdf->download('laporan-transaksi-' . Carbon::now()->format('d-m-Y') . '.pdf');
    }

    public function exportDetailPdf($id)
    {
        $transaction = Transaction::with(['user', 'items.product'])->findOrFail($id);

        $pdf = Pdf::loadView('laporan.detail-pdf', compact('transaction'));

        return $pdf->download('detail-transaksi-' . $transaction->kode_transaksi . '.pdf');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        
        // Delete related transaction items
        $transaction->items()->delete();
        
        // Delete the transaction
        $transaction->delete();

        return redirect()->route('laporan.index')->with('success', 'Transaksi berhasil dihapus');
    }

    public function clearAllExceptAdmin()
    {
        // Get admin user IDs
        $adminIds = User::where('role', 'admin')->pluck('id');
        
        // Delete transactions not created by admin
        $transactionsToDelete = Transaction::whereNotIn('user_id', $adminIds)->get();
        
        foreach ($transactionsToDelete as $transaction) {
            $transaction->items()->delete();
            $transaction->delete();
        }

        return redirect()->route('laporan.index')->with('success', 'Semua transaksi kecuali admin berhasil dihapus');
    }
}
