<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing products and users
        $products = Product::all();
        $users = User::where('role', 'kasir')->get();

        if ($products->isEmpty() || $users->isEmpty()) {
            return; // Skip if no products or kasir users
        }

        // Create transactions for the last 7 days
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->subDays($i);
            $numTransactions = rand(3, 8); // 3-8 transactions per day

            for ($j = 0; $j < $numTransactions; $j++) {
                $user = $users->random();
                $transactionProducts = $products->random(rand(1, 3)); // 1-3 products per transaction

                $total = 0;
                $items = [];

                foreach ($transactionProducts as $product) {
                    $qty = rand(1, 5);
                    $harga = $product->harga;
                    $subtotal = $qty * $harga;
                    $total += $subtotal;

                    $items[] = [
                        'product_id' => $product->id,
                        'qty' => $qty,
                        'harga' => $harga,
                        'subtotal' => $subtotal,
                    ];
                }

                $bayar = $total + rand(0, 1000); // Add some change
                $kembalian = $bayar - $total;

                $transaction = Transaction::create([
                    'kode_transaksi' => 'TRX-' . $date->format('Ymd') . '-' . str_pad($j + 1, 3, '0', STR_PAD_LEFT),
                    'user_id' => $user->id,
                    'total' => $total,
                    'bayar' => $bayar,
                    'kembalian' => $kembalian,
                    'created_at' => $date->copy()->addHours(rand(8, 20))->addMinutes(rand(0, 59)), // Random time between 8 AM - 8 PM
                ]);

                foreach ($items as $item) {
                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $item['product_id'],
                        'qty' => $item['qty'],
                        'harga' => $item['harga'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    // Reduce stock
                    $product = Product::find($item['product_id']);
                    $product->decrement('stok', $item['qty']);
                }
            }
        }
    }
}
