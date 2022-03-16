<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Kelas;
use Config;
use Illuminate\Support\Facades\Validator;
 
class KelasController extends Controller
{
    function __construct()
        {
            Config::set('jwt.user', \App\Petugas::class);
            Config::set('auth.providers', ['users' => [
                    'driver' => 'eloquent',
                    'model' => \App\Petugas::class,
                ]]);
        }
 
    public function store(Request $req){
        $validator = Validator::make($req->all(), [
            'nama_kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'angkatan' => 'required|string|max:255'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $save = Kelas::create([
                'nama_kelas' => $req->get('nama_kelas'),
                'jurusan' => $req->get('jurusan'),
                'angkatan' => $req->get('angkatan')
        ]);
        if($save){
            return response()->json(['status' => 'kelas berhasil ditambhakan']);
        } else {
            return response()->json(['status' => 'kelas gagal ditambahkan']);
        }
    }
 
    public function update(Request $req, $id){
        $validator = Validator::make($req->all(), [
            'nama_kelas' => 'required',
            'jurusan' => 'required',
            'angkatan' => 'required'
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors());
        }
        $update = Kelas::where('id_kelas', $id)->update([
            'nama_kelas' => $req->get('nama_kelas'),
            'jurusan' => $req->get('jurusan'),
            'angkatan' => $req->get('angkatan')
        ]);
        if ($update){
            return response()->json(['status'=>'berhasil update kelas']);
        } else {
            return response()->json(['status' => 'gagal update kelas']);
        }
    }
 
    public function delete($id){
        $kelas = Kelas::where('id_kelas', $id)->delete();
        if($kelas){
            return response()->json(['status' => 'berhasil hapus kelas']);
        } else {
            return response()->json(['status' => 'gagal hapus kelas']);
        }
    }
}
