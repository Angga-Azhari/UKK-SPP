<?php

namespace App\Http\Controllers;
 
use App\Petugas;
use Illuminate\Http\Request;
use Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
 
class PetugasController extends Controller
{
    function __construct()
        {
            Config::set('jwt.user', \App\Petugas::class);
            Config::set('auth.providers', ['users' => [
                    'driver' => 'eloquent',
                    'model' => \App\Petugas::class,
                ]]);
        }
 
        public function login(Request $request){
        $credentials = $request->only('email', 'password');
        try{
            if(! $token = JWTAuth::attempt($credentials)){
                return response()->json(['error' => 'invalid_credentials', 400]);
            }
        } catch(JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }
 
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_petugas' => 'required|string|max:255',
            'email' =>'required|string|email|max:255|unique:users',
            'password' =>'required|string|min:6|confirmed',
            'role' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
       /* $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role' => $request->get('role')
        ]); */
        $petugas = Petugas::create([
            'nama_petugas' => $request->get('nama_petugas'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role' => $request->get('role')
        ]);
        $token = JWTAuth::fromUser($petugas);
        return response()->json(compact('petugas', 'token'), 201);
    }
 
    public function getAuthenticatedUser(){
        try{
            if(! $user = JWTAuth::parseToken()->authenticate()){
                return response()->json(['use_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e){
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }
 
    public function getprofile()
    {
        return response()->json(['data'=>JWTAuth::user()]);
    }
 
    public function getprofileadmin()
    {
        return response()->json(['data'=>JWTAuth::user()]);
    }
}
