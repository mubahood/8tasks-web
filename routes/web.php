<?php

use Carbon\Carbon;
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

Route::get('/', function () {

    $main_date =  Carbon::parse('2022-06-25 00:00:00.000')->format('Y-m-d');
    $t = Carbon::parse('0001-01-01 12:00:00.000');
    $_t =  $t->format('H:i:s');
    die($main_date." ".$_t);
    die("Romina");
    return view('welcome');
});
