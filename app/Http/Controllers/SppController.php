<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Spp;
use Illuminate\Support\Facades\Validator;
 
class SppController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'angkatan' => 'required',
            'tahun' => 'required',
            'nominal'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }        
        $kelas = Spp::create([
            'angkatan'=>$request->get('angkatan'),
            'tahun'=>$request->get('tahun'),
            'nominal'=>$request->get('nominal'),
        ]);
        if($kelas){
            return Response()->json(['status' => 'Spp berhasil ditambahkan']);
        } else {
            return Response()->json(['status' => 'Spp gagal ditambahkan']);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'angkatan' => 'required',
            'tahun' => 'required',
            'nominal'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }        
        $kelas = Spp::where('id_spp',$id)->update([
            'angkatan'=>$request->get('angkatan'),
            'tahun'=>$request->get('tahun'),
            'nominal'=>$request->get('nominal'),
        ]);
        if($kelas){
            return Response()->json(['status' => 'Spp berhasil diUpdate']);
        } else {
            return Response()->json(['status' => 'Spp gagal diUpdate']);
        }
    }
    public function destroy($id)
    {
        $kelas = Spp::where('id_spp',$id)->delete();
        if($kelas){
            return Response()->json(['status' => 'Spp berhasil dihapus']);
        } else {
            return Response()->json(['status' => 'Spp gagal dihapus']);
        }
    }
}
