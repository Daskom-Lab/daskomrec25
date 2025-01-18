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
    return view('CaAs.LandingCaas');
});
Route::get('/LoginCaas', function () {
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
    return view('CaAs.AssistansPage');
});
Route::get('/LoginAdmin', function () {
    return view('Admin.LoginAdmin');
});
Route::get('/LandingCaas', function () {
    return view('CaAs.LandingCaas');
});

Route::get('/ChooseShift', function () {
    return view('CaAs.ChooseShift');
});
Route::get('/Shift', function () {
    return view('CaAs.FixShift');
});
Route::get('/ChooseGem', function () {
    return view('CaAs.ChooseGem');
});
Route::get('/Gem', function () {
    return view('CaAs.FixGem');
});
Route::get('/LoginAdmin', function () {
    return view('Admin.LoginAdmin');
});
