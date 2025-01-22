<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\TransaksiController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::get('/transaksi/data', [TransaksiController::class, 'getTransaksiData'])->name('transaksi.getData');
Route::post('transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('transaksi/{id}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
Route::delete('transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
Route::put('/transaksi/{id}/', [TransaksiController::class, 'update'])->name('transaksi.update');


Route::get('/suplier', [SuplierController::class, 'index'])->name('suplier.index');
Route::get('/suplier/data', [SuplierController::class, 'getDataSuplier'])->name('suplier.getDataSuplier');
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/barang/data', [BarangController::class, 'getDataBarang'])->name('barang.getDataBarang');
Route::get('/stok', [StockController::class, 'index'])->name('stok.index');
Route::get('/stok/data', [StockController::class, 'getDataStock'])->name('stok.getDataStock');
