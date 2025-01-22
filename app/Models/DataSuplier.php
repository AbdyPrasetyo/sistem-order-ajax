<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataSuplier extends Model
{
    //
    use HasFactory;
    protected $table = 'tbl_suplier';

    protected $fillable =[
        'kodespl',
        'namaspl'
    ];


    public function transaksi(): HasMany
    {
        return $this->hasMany(DataTransaksi::class, 'id_suplier', 'id');
    }

}
