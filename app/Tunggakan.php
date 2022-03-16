<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Tunggakan extends Model
{
    protected $table='tunggakan';
    protected $primaryKey='id_tunggakan';
    protected $fillable=[
        'nisn','bulan_spp','tahun_spp','status_lunas'
    ];
 
    public $timestamps = false;
 
}
