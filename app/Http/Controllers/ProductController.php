<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $products = Product::when($search, function ($query) use ($search) {
            return $query->where('nama_barang', 'like', '%' . $search . '%');
        })->paginate(10);

        return view('products.index', compact('products', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nama_barang', 'harga', 'stok']);

        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('products', 'public');
            $data['gambar'] = $imagePath;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nama_barang', 'harga', 'stok']);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($product->gambar && Storage::exists('public/' . $product->gambar)) {
                Storage::delete('public/' . $product->gambar);
            }

            $imagePath = $request->file('gambar')->store('products', 'public');
            $data['gambar'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Barang berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Hapus gambar jika ada
        if ($product->gambar && Storage::exists('public/' . $product->gambar)) {
            Storage::delete('public/' . $product->gambar);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Barang berhasil dihapus!');
    }
}
