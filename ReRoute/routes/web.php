<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;


Route::get('/', [MainController::class, 'index']);

Route::get('/login/{name}/{password}', [MainController::class, 'login']);
Route::get('/login/{failed?}', [MainController::class, 'loginPage']);

Route::get('/addService/{name}/{ip}/{isHttps}', [MainController::class, 'addService']);
Route::get('/cpuUsage', [MainController::class, 'cpuUsage']);

?>