<?php

namespace App\Http\Controllers;

use App\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Config;
use Auth;

class siswaController extends Controller
{

    function __construct()
    {
        Config::set('jwt.user', \App\Siswa::class);
        Config::set('auth.providers', ['users' => [
            'driver' => 'eloquent',
            'model' => \App\Siswa::class,
        ]]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:255',
            'id_kelas' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'email' => 'required|string|email|max:255|unique:siswa'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $siswa = Siswa::create([
            'nis' => $request->get('nis'),
            'nama' => $request->get('nama'),
            'alamat' => $request->get('alamat'),
            'no_telp' => $request->get('no_telp'),
            'password' => Hash::make($request->get('password')),
            'email' => $request->get('email'),
            'id_kelas' => $request->get('id_kelas'),
        ]);
        $token = JWTAuth::fromUser($siswa);
        return response()->json(compact('siswa', 'token'), 201);
    }


    public function getprofile()
    {
        return response()->json(['data' => JWTAuth::user()]);
    }
    public function getSiswaKelas()
    {
        $getsiswa = Siswa::join('kelas', 'kelas.id_kelas', 'siswa.id_kelas')->get();
        return response()->json(['data' => $getsiswa]);
    }
}
