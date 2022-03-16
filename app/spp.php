<?php

namespace App;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Spp extends Model
{
    //use HasFactory;
    protected $table='spp';
    protected $primaryKey='id_spp';
    public $timestamps=false;
    protected $fillable=[
        'angkatan','tahun','nominal'
    ];
}
