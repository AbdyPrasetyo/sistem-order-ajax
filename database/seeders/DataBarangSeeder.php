<?php

namespace Database\Seeders;

use App\Models\DataStok;
use App\Models\DataBarang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DataBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $barangData = [
            ['kodebrg' => 'BRG001', 'namabrg' => 'Barang A', 'satuan' => 'pcs', 'hargabeli' => 10000],
            ['kodebrg' => 'BRG002', 'namabrg' => 'Barang B', 'satuan' => 'kg', 'hargabeli' => 20000],
            ['kodebrg' => 'BRG003', 'namabrg' => 'Barang C', 'satuan' => 'ltr', 'hargabeli' => 15000],
            ['kodebrg' => 'BRG004', 'namabrg' => 'Barang D', 'satuan' => 'pcs', 'hargabeli' => 12000],
            ['kodebrg' => 'BRG005', 'namabrg' => 'Barang E', 'satuan' => 'kg', 'hargabeli' => 5000],
            ['kodebrg' => 'BRG006', 'namabrg' => 'Barang F', 'satuan' => 'kg', 'hargabeli' => 30000],
            ['kodebrg' => 'BRG007', 'namabrg' => 'Barang G', 'satuan' => 'ltr', 'hargabeli' => 8000],
            ['kodebrg' => 'BRG008', 'namabrg' => 'Barang H', 'satuan' => 'pcs', 'hargabeli' => 40000],
            ['kodebrg' => 'BRG009', 'namabrg' => 'Barang I', 'satuan' => 'kg', 'hargabeli' => 25000],
            ['kodebrg' => 'BRG010', 'namabrg' => 'Barang J', 'satuan' => 'kg', 'hargabeli' => 10000],
        ];

        foreach ($barangData as $data) {
            $barang = DataBarang::create($data);

            DataStok::create([
                'id_barang' => $barang->id,
                'qty' => rand(10, 100),
            ]);
        }
    }
}
