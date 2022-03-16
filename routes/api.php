<?php

use Illuminate\Http\Request;
//login & Register
Route::post('register_petugas', 'PetugasController@register');
Route::post('login_petugas', 'PetugasController@login');
Route::post('register_siswa', 'SiswaController@register');
Route::post('login_siswa', 'SiswaController@login');


Route::get('book', 'BookController@book');
Route::get('bookall', 'BookController@bookAuth')->middleware('jwt.verify');


//Hak Akses petugas
Route::middleware(['jwt.verify:petugas'])->group(function () {
    Route::get('/get_profile_petugas', 'PetugasController@getprofile');

    Route::post('pembayaran', 'TransaksiController@store');
    Route::get('tunggakan/{id}', 'TransaksiController@kurang_bayar');
});


    //Hak Akses Siswa
    Route::group(['middleware' => ['jwt.siswa.verify']], function () {
        Route::get('/get_profile_siswa', 'SiswaController@getprofile');
    });
    
    Route::middleware(['jwt.verify:admin'])->group(function () {
        Route::get('get_profil_admin', 'PetugasController@getprofileadmin');
    //CRUD Kelas
    Route::post('insert_kelas', 'KelasController@store');
    Route::put('update/kelas/{id}', 'KelasController@update');
    Route::delete('delete/kelas/{id}', 'KelasController@delete');

    //CRUD Spp
    Route::post('insert_spp', 'SppController@store');
    Route::put('/update_spp/{id}', 'SppController@update');
    Route::delete('/delete_spp/{id}', 'SppController@destroy');

    //CRUD Siswa
    Route::put('/update_siswa/{id}', 'KelolaSiswaController@update');
    Route::delete('/delete_siswa/{id}', 'KelolaSiswaController@destroy');

    Route::get('get_siswa', 'SiswaController@getSiswaKelas');
});
