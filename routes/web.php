<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('dashboard.locales')->group(function () {
    Auth::routes();
});

Route::redirect('/home', '/dashboard');

Route::impersonate();

Route::get('/number-to-string/{number?}', function ($number = null) {
    $number = str_replace(',', '', $number);
    return response()->json([
        'string' => $number ? price_string($number) : '',
    ]);
});

Route::get('/', function () {
    return view('welcome');
});
