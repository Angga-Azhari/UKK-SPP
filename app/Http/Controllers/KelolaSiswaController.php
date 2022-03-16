<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siswa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class KelolaSiswaController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nisn' => 'required|unique:siswa',
            'nis' => 'required|unique:siswa',
            'nama' => 'required',
            'id_kelas' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'email' => 'email',
            'password' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $siswa = Siswa::create([
            'nisn' => $request->get('nisn'),
            'nis' => $request->get('nis'),
            'nama' => $request->get('nama'),
            'id_kelas' => $request->get('id_kelas'),
            'alamat' => $request->get('alamat'),
            'no_telp' => $request->get('no_telp'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        if ($siswa) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required|unique:siswa',
            'nama' => 'required',
            'id_kelas' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'email' => 'email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $siswa = Siswa::where('nisn', $id)->update([
            'nis' => $request->get('nis'),
            'nama' => $request->get('nama'),
            'id_kelas' => $request->get('id_kelas'),
            'alamat' => $request->get('alamat'),
            'no_telp' => $request->get('no_telp'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        if ($siswa) {
            return Response()->json(['status' => 'Siswa berhasil diUpdate']);
        } else {
            return Response()->json(['status' => 'Siswa gagal diUpdate']);
        }
    }
    public function destroy($id)
    {
        $siswa = Siswa::where('nisn', $id)->delete();
        if ($siswa) {
            return Response()->json(['status' => 'Siswa berhasil dihapus']);
        } else {
            return Response()->json(['status' => 'Siswa gagal dihapus']);
        }
    }
}
