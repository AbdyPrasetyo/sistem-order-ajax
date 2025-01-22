<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataStok extends Model
{
    //
    use HasFactory;

    protected $table = 'tbl_stock';

    protected $fillable =[
        'id_barang',
        'qty'
    ];



    public function barang(): BelongsTo
    {
        return $this->belongsTo(DataBarang::class, 'id_barang', 'id');
    }
}
