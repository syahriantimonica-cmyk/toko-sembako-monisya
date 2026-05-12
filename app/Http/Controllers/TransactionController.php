<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    private function generateKodeTransaksi(): string
    {
        $today = Carbon::now()->format('Ymd');
        $latestTransaction = Transaction::whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();

        $number = 1;
        if ($latestTransaction) {
            $lastNumber = (int) substr($latestTransaction->kode_transaksi, -4);
            $number = $lastNumber + 1;
        }

        return 'TRX-' . $today . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    private function getCartJsonResponse(string $message)
    {
        $cart = session()->get('cart', []);
        $cartCount = collect($cart)->sum('qty');
        $cartTotal = collect($cart)->sum('subtotal');
        
        $cartHtml = view('transaksi.partials.cart_sidebar', compact('cart', 'cartCount', 'cartTotal'))->render();

        return response()->json([
            'success' => true,
            'message' => $message,
            'cart_html' => $cartHtml,
            'cart_count' => $cartCount,
            'cart_total' => $cartTotal
        ]);
    }

    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $query = Product::query();

        if ($search) {
            $query->where('nama_barang', 'like', '%' . $search . '%');
        }

        $products = $query->paginate(20);
        $cart = session()->get('cart', []);
        $cartTotal = collect($cart)->sum('subtotal');
        $cartCount = collect($cart)->sum('qty');

        return view('transaksi.index', compact('products', 'cart', 'cartTotal', 'cartCount', 'search'));
    }

    public function addCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);
        $key = 'product_' . $product->id;

        $newQty = $request->qty;
        if (isset($cart[$key])) {
            $newQty = $cart[$key]['qty'] + $request->qty;
        }

        if ($product->stok < $newQty) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Stok tidak cukup. Stok tersedia: ' . $product->stok], 400);
            }
            return redirect()->back()->with('error', 'Stok tidak cukup. Stok tersedia: ' . $product->stok);
        }

        $cart[$key] = [
            'product_id' => $product->id,
            'nama_barang' => $product->nama_barang,
            'harga' => $product->harga,
            'qty' => $newQty,
            'subtotal' => $product->harga * $newQty,
            'gambar_url' => $product->gambar_url,
        ];

        session()->put('cart', $cart);

        if ($request->ajax() || $request->wantsJson()) {
            return $this->getCartJsonResponse('Item berhasil ditambahkan');
        }
        return redirect()->route('transaksi.index')->with('success', 'Item berhasil ditambahkan ke keranjang');
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $key = 'product_' . $product->id;
        $cart = session()->get('cart', []);

        if (! isset($cart[$key])) {
            if ($request->ajax() || $request->wantsJson()) return response()->json(['error' => 'Item tidak ditemukan'], 404);
            return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang');
        }

        if ($product->stok < $request->qty) {
            if ($request->ajax() || $request->wantsJson()) return response()->json(['error' => 'Stok tidak cukup'], 400);
            return redirect()->back()->with('error', 'Stok tidak cukup. Stok tersedia: ' . $product->stok);
        }

        $cart[$key]['qty'] = $request->qty;
        $cart[$key]['subtotal'] = $cart[$key]['harga'] * $cart[$key]['qty'];
        session()->put('cart', $cart);

        if ($request->ajax() || $request->wantsJson()) {
            return $this->getCartJsonResponse('Keranjang berhasil diperbarui');
        }
        return redirect()->route('transaksi.index')->with('success', 'Keranjang berhasil diperbarui');
    }

    public function removeCart(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $key = 'product_' . $request->product_id;
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return $this->getCartJsonResponse('Item berhasil dihapus');
        }
        return redirect()->route('transaksi.index')->with('success', 'Item berhasil dihapus dari keranjang');
    }

    public function checkout(Request $request)
    {
        $request->validate(['bayar' => 'required|numeric|min:0']);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang masih kosong');
        }

        $total = collect($cart)->sum('subtotal');
        $bayar = (float) $request->bayar;

        if ($bayar < $total) {
            return redirect()->back()->withInput()->with('error', 'Pembayaran tidak cukup. Total: Rp ' . number_format($total, 0, ',', '.'));
        }

        $kembalian = $bayar - $total;

        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'kode_transaksi' => $this->generateKodeTransaksi(),
                'user_id' => Auth::id(),
                'total' => $total,
                'bayar' => $bayar,
                'kembalian' => $kembalian,
            ]);

            foreach ($cart as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stok < $item['qty']) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Stok produk "' . $product->nama_barang . '" tidak cukup');
                }

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['subtotal'],
                ]);

                $product->decrement('stok', $item['qty']);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('transaksi.show', $transaction)->with('success', 'Transaksi berhasil. Kode: ' . $transaction->kode_transaksi);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function history(Request $request)
    {
        $query = Transaction::query();

        if (Auth::user()->role === 'kasir') {
            $query->where('user_id', Auth::id());
        }

        if ($request->filled('search')) {
            $query->where(function ($sub) use ($request) {
                $sub->where('kode_transaksi', 'like', '%' . $request->search . '%');

                if (Auth::user()->role !== 'kasir') {
                    $sub->orWhereHas('user', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
                }
            });
        }

        $transactions = $query->with('user')->latest()->paginate(10);

        return view('transaksi.history', compact('transactions'));
    }

    public function adminHistory(Request $request)
    {
        $query = Transaction::with('user');
        if ($request->filled('search')) {
            $query->where('kode_transaksi', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        $transactions = $query->latest()->paginate(10);

        return view('transaksi.admin-history', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        if (Auth::user()->role === 'kasir' && $transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->load('items.product', 'user');
        return view('transaksi.show', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        if (Auth::user()->role === 'kasir' && $transaction->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete related transaction items
        $transaction->items()->delete();
        
        // Delete the transaction
        $transaction->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus');
    }
}
