<?php

namespace App;
 
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
 
class Siswa extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table='siswa';
    protected $primaryKey="nisn";
    protected $fillable=[
        'nis', 'nama', 'id_kelas', 'alamat', 'no_telp', 'email', 'password'
    ];
   
    public $timestamps=false;
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
 
    public function getJWTCustomClaims()
    {
        return [];
    }
}
