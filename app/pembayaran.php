<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $fillable = [
        'id_petugas', 'nisn', 'tgl_bayar', 'bulan_spp', 'tahun_spp'
    ];
    public $timestamps = false;
}
