<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineBatchesAndStocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all existing medicines
        $medicines = \App\Models\Obat::all();

        if ($medicines->isEmpty()) {
            $this->command->info('Tidak ada data obat di tabel medicines. Silakan isi dulu Master Obat.');
            return;
        }

        $this->command->info('Membuat dummy data Batches dan Stocks untuk ' . $medicines->count() . ' obat...');

        foreach ($medicines as $medicine) {
            // Kita buat 1-2 batch acak untuk setiap obat
            $numberOfBatches = rand(1, 2);

            for ($i = 1; $i <= $numberOfBatches; $i++) {
                // 1. Buat Batch Baru
                $batchNumber = 'BATCH-' . date('Ym') . '-' . str_pad($medicine->id, 3, '0', STR_PAD_LEFT) . '-' . $i;
                
                // Expired Date antara 6 bulan sampai 2 tahun ke depan
                $expiredDate = now()->addMonths(rand(6, 24))->format('Y-m-d');
                
                // Harga beli/jual batch disamakan dengan master obat (atau bisa dimodifikasi sedikit)
                $purchasePrice = $medicine->purchase_price;
                $sellingPrice = $medicine->selling_price;

                $batchId = \Illuminate\Support\Facades\DB::table('medicine_batches')->insertGetId([
                    'medicine_id' => $medicine->id,
                    'batch_number' => $batchNumber,
                    'expired_date' => $expiredDate,
                    'purchase_price' => $purchasePrice,
                    'selling_price' => $sellingPrice,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // 2. Buat Stok untuk Batch tersebut
                $initialStock = rand(10, 150); // Stok acak antara 10 - 150

                \Illuminate\Support\Facades\DB::table('medicine_stocks')->insert([
                    'medicine_id' => $medicine->id,
                    'batch_id' => $batchId,
                    'stock_qty' => $initialStock, // Stok awal opname
                    'stock_in' => 0,              // Berapa yang sudah dibeli lagi (kulakan)
                    'stock_out' => 0,             // Berapa yang sudah terjual
                    'last_stock' => $initialStock, // Sisa saat ini
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Berhasil mengenerate dummy data untuk medicine_batches dan medicine_stocks!');
    }
}
