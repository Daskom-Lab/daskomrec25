<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('CaAs.LoginCaAs');
});
Route::get('/CaAs', function () {
    return view('CaAs.HomePageCaAs');
});
Route::get('/Profile', function () {
    return view('CaAs.ProfileCaAs');
});
Route::get('/ChangePassword', function () {
    return view('CaAs.ChangePassword');
});
Route::get('/Announcement', function () {
    return view('CaAs.Announcement');
});
Route::get('/Assistants', function () {
    return view('CaAs.AssistantsPage');
});
Route::get('/LoginAdmin', function () {
    return view('Admin.LoginAdmin');
});
