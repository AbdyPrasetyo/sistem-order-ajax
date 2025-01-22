<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataTransaksi extends Model
{
    //
    use HasFactory;

    protected $table = 'tbl_hbeli';

    protected $fillable =[
        'notransaksi',
        'id_suplier',
        'tglbeli'
    ];


    public function suplier(): BelongsTo
    {
        return $this->belongsTo(DataSuplier::class, 'id_suplier', 'id');
    }


    public function detailtransaksi(): HasMany
    {
        return $this->hasMany(DataDetailTransaksi::class, 'id_hbeli', 'id');
    }
}
