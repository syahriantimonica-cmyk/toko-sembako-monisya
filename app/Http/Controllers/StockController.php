<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $filter = $request->query('filter', 'all');

        $products = Product::query()
            ->when($search, fn($query) => $query->where('nama_barang', 'like', '%' . $search . '%'))
            ->when($filter !== 'all', function ($query) use ($filter) {
                return match ($filter) {
                    'aman' => $query->where('stok', '>', 20),
                    'menipis' => $query->whereBetween('stok', [5, 20]),
                    'kritis' => $query->where('stok', '<', 5),
                    default => $query,
                };
            })
            ->orderBy('stok')
            ->paginate(12)
            ->withQueryString();

        return view('stok.index', compact('products', 'search', 'filter'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'add_stock' => ['nullable', 'integer', 'min:0'],
            'reduce_stock' => ['nullable', 'integer', 'min:0'],
        ]);

        $addStock = (int) $request->input('add_stock', 0);
        $reduceStock = (int) $request->input('reduce_stock', 0);

        if ($addStock === 0 && $reduceStock === 0) {
            return back()->withErrors(['update' => 'Masukkan jumlah tambah atau kurangi stok.']);
        }

        if ($reduceStock > 0 && $product->stok - $reduceStock < 0) {
            return back()->withErrors(['update' => 'Stok tidak boleh minus. Stok saat ini: ' . $product->stok]);
        }

        $product->stok += $addStock;
        $product->stok -= $reduceStock;
        $product->save();

        return back()->with('success', "Stok produk \"{$product->nama_barang}\" berhasil diperbarui. Stok sekarang {$product->stok}.");
    }
}
