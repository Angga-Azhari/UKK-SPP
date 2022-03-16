<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\pembayaran;
use JWTAuth;
use Validator;
use App\tunggakan;
use Config;
 
class TransaksiController extends Controller
{
    function __construct()
        {
            Config::set('jwt.user', \App\Petugas::class);
            Config::set('auth.providers', ['users' => [
                    'driver' => 'eloquent',
                    'model' => \App\Petugas::class,
                ]]);
        }
 
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nisn' => 'required',
            'bulan_spp'=>'required',
            'tahun_spp'=>'required',
            'tgl_bayar'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $ceklunas=tunggakan::where('nisn',$request->get('nisn'))
            ->where('bulan_spp',$request->get('bulan_spp'))
            ->where('tahun_spp',$request->get('tahun_spp'));
        if($ceklunas->count()>0){
            $dt_status=$ceklunas->first();
            if($dt_status->status=="belum lunas"){
                $pembayaran = pembayaran::create([
                    'id_petugas'=>JWTAuth::user()->id_petugas,
                    'nisn'=>$request->get('nisn'),
                    'tgl_bayar'=>date('Y-m-d'),
                    'bulan_spp'=>$request->get('bulan_spp'),
                    'tahun_spp'=>$request->get('tahun_spp'),
                ]);
                if($pembayaran){
                    $updat_tunggakan=tunggakan::where('nisn',$request->get('nisn'))
                    ->where('bulan_spp',$request->get('bulan_spp'))
                    ->where('tahun_spp',$request->get('tahun_spp'))
                    ->update([
                        'status'=>'lunas'
                    ]);
                    return response()->json(['message'=>'sukses pembayaran','status'=>true]);
                } else {
                    return response()->json(['message'=>'Gagal pembayaran','status'=>false]);
                }
            } elseif($dt_status->status=="lunas"){
                return response()->json(['message'=>'Bulan ini sudah lunas, tidak perlu membayar','status'=>false]);
            }
        } else {
                return response()->json(['message'=>'Tidak ada tunggakan','status'=>false]);
            }
       
       
    }
    public function kurang_bayar($id)
    {
        $gethistori=tunggakan::select('siswa.nisn','siswa.nama','kelas.nama_kelas','kelas.jurusan','nominal')->join('siswa','siswa.nisn','=','tunggakan.nisn')
        ->join('kelas','kelas.id_kelas','=','siswa.id_kelas')
        ->join('spp','spp.angkatan','=','kelas.angkatan')
        ->where('tunggakan.nisn',$id)
        ->where('status','belum lunas')
        ->get();
        return response()->json($gethistori);
    }
}

