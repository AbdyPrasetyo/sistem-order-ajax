<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DataSuplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supliers = [
            ['kodespl' => 'SPL001', 'namaspl' => 'Suplier Alpha'],
            ['kodespl' => 'SPL002', 'namaspl' => 'Suplier Beta'],
            ['kodespl' => 'SPL003', 'namaspl' => 'Suplier Gamma'],
            ['kodespl' => 'SPL004', 'namaspl' => 'Suplier Delta'],
            ['kodespl' => 'SPL005', 'namaspl' => 'Suplier Epsilon'],
            ['kodespl' => 'SPL006', 'namaspl' => 'Suplier Zeta'],
            ['kodespl' => 'SPL007', 'namaspl' => 'Suplier Eta'],
            ['kodespl' => 'SPL008', 'namaspl' => 'Suplier Feta'],
            ['kodespl' => 'SPL009', 'namaspl' => 'Suplier Gota'],
            ['kodespl' => 'SPL010', 'namaspl' => 'Suplier Happa'],
        ];

        DB::table('tbl_suplier')->insert($supliers);

    }
}
