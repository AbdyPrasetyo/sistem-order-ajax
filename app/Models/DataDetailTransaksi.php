<?php

namespace App\Models;

use App\Models\DataBarang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataDetailTransaksi extends Model
{
    //
    use HasFactory;

    protected $table = 'tbl_dbeli';

    protected $fillable =[
        'id_hbeli',
        'id_barang',
        'qty',
        'diskon',
        'diskonrp',
        'totalrp'
    ];




    public function barang(): BelongsTo
    {
        return $this->belongsTo(DataBarang::class, 'id_barang', 'id');
    }
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(DataTransaksi::class, 'id_hbeli', 'id');
    }
}
