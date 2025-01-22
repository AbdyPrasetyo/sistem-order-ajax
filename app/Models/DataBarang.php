<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataBarang extends Model
{
    use HasFactory;

    protected $table = 'tbl_barang';

    protected $fillable =[
        'kodebrg',
        'namabrg',
        'satuan',
        'hargabeli'
    ];


    public function stock(): HasOne
    {
        return $this->hasOne(DataStok::class, 'id_barang', 'id');
    }


    public function detailtransaksi(): HasMany
    {
        return $this->hasMany(DataDetailTransaksi::class, 'id_barang', 'id');
    }
}
