<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\DataBarang;
use App\Models\DataSuplier;
use App\Models\DataTransaksi;
use Illuminate\Database\Seeder;
use App\Models\DataDetailTransaksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $currentYear = Carbon::now()->format('Y');
        $currentMonth = Carbon::now()->format('m');
        $transactionNumber = 1;


        $supliers = DataSuplier::all();
        $barangs = DataBarang::all();

        for ($i = 1; $i <= 15; $i++) {

            $formattedNumber = str_pad($transactionNumber, 3, '0', STR_PAD_LEFT);
            $notransaksi = "B{$currentYear}{$currentMonth}{$formattedNumber}";


            $suplier = $supliers->random();


            $transaksi = DataTransaksi::create([
                'notransaksi' => $notransaksi,
                'id_suplier' => $suplier->id,
                'tglbeli' => Carbon::now()->subDays(rand(1, 30)),
            ]);


            $totalDetails = rand(1, 5);
            for ($j = 0; $j < $totalDetails; $j++) {
                $barang = $barangs->random();
                $hargabeli = $barang->hargabeli;
                $qty = rand(1, 20);
                $diskon = rand(0, 20);
                $totalrp = $qty * $hargabeli;
                $diskonrp = $totalrp * $diskon / 100;

                DataDetailTransaksi::create([
                    'id_hbeli' => $transaksi->id,
                    'id_barang' => $barang->id,
                    'qty' => $qty,
                    'diskon' => $diskon,
                    'diskonrp' => $diskonrp,
                    'totalrp' => $totalrp,
                ]);
            }

            $transactionNumber++;
        }
    }
}
