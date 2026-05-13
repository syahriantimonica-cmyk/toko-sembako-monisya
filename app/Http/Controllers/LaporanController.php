<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // =====================
    // HALAMAN LAPORAN
    // =====================

    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'items.product']);

        // Filter harian
        if ($request->filter == 'harian') {
            $query->whereDate('created_at', Carbon::today());
        }

        // Filter bulanan
        if ($request->filter == 'bulanan') {
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
        }

        // Search
        if (!empty($request->search)) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('kode_transaksi', 'like', '%' . $search . '%')

                  ->orWhereHas('user', function ($userQuery) use ($search) {

                      $userQuery->where('name', 'like', '%' . $search . '%');

                  });

            });
        }

        $transactions = $query
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('laporan.index', compact('transactions'));
    }


    // =====================
    // DETAIL LAPORAN
    // =====================

    public function detail($id)
    {
        $transaction = Transaction::with([
            'user',
            'items.product'
        ])->findOrFail($id);

        return view('laporan.detail', compact('transaction'));
    }


    // =====================
    // EXPORT PDF SEMUA
    // =====================

    public function exportPdf(Request $request)
    {
        $query = Transaction::with([
            'user',
            'items.product'
        ]);

        // Filter harian
        if ($request->filter == 'harian') {
            $query->whereDate('created_at', Carbon::today());
        }

        // Filter bulanan
        if ($request->filter == 'bulanan') {
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
        }

        $transactions = $query
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPendapatan = $transactions->sum('total');

        $pdf = Pdf::loadView(
            'laporan.pdf',
            compact('transactions', 'totalPendapatan')
        );

        return $pdf->download(
            'laporan-transaksi-' . Carbon::now()->format('d-m-Y') . '.pdf'
        );
    }


    // =====================
    // EXPORT DETAIL PDF
    // =====================

    public function exportDetailPdf($id)
    {
        $transaction = Transaction::with([
            'user',
            'items.product'
        ])->findOrFail($id);

        $pdf = Pdf::loadView(
            'laporan.detail-pdf',
            compact('transaction')
        );

        return $pdf->download(
            'detail-transaksi-' .
            $transaction->kode_transaksi .
            '.pdf'
        );
    }


    // =====================
    // HAPUS TRANSAKSI
    // =====================

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        // Hapus item transaksi
        $transaction->items()->delete();

        // Hapus transaksi
        $transaction->delete();

        return redirect()
            ->route('laporan.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }


    // =====================
    // HAPUS SEMUA KECUALI ADMIN
    // =====================

    public function clearAllExceptAdmin()
    {
        $adminIds = User::where('role', 'admin')->pluck('id');

        $transactions = Transaction::whereNotIn(
            'user_id',
            $adminIds
        )->get();

        foreach ($transactions as $transaction) {

            $transaction->items()->delete();

            $transaction->delete();
        }

        return redirect()
            ->route('laporan.index')
            ->with(
                'success',
                'Semua transaksi kecuali admin berhasil dihapus'
            );
    }
}