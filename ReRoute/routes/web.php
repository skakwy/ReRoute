<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;


Route::get('/', [MainController::class, 'index']);

Route::get('/login/{name}/{password}', [MainController::class, 'login']);
Route::get('/login/{failed?}', [MainController::class, 'loginPage']);


//api
Route::get('/addService/{name}/{ip}/{isHttps}', [MainController::class, 'addService']);
Route::get('/deleteService/{name}', [MainController::class, 'deleteService']);
Route::get('/changeService/{oldName}/{isHttps}/{newName}/{newURL}', [MainController::class, 'changeService']);
Route::get('/cpuUsage', [MainController::class, 'cpuUsage']);

?>