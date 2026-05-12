<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'nama_barang' => 'Beras Premium 5kg',
                'harga' => 75000,
                'stok' => 25,
            ],
            [
                'nama_barang' => 'Minyak Goreng 2L',
                'harga' => 35000,
                'stok' => 15,
            ],
            [
                'nama_barang' => 'Gula Pasir 1kg',
                'harga' => 15000,
                'stok' => 30,
            ],
            [
                'nama_barang' => 'Telur Ayam 1kg',
                'harga' => 28000,
                'stok' => 20,
            ],
            [
                'nama_barang' => 'Susu UHT 1L',
                'harga' => 18000,
                'stok' => 12,
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
