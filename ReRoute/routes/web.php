<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\DockerCom;


Route::get('/', [MainController::class, 'index']);


Route::get('/login/{failed?}', [MainController::class, 'loginPage']);
Route::get('/dashboard', [MainController::class, 'dashboard']);


//api
Route::get('/api/login/{name}/{password}', [MainController::class, 'login']);
Route::get('/api/logout', [MainController::class, 'logout']);
Route::get('/api/addService/{name}/{ip}/{isHttps}', [MainController::class, 'addService']);
Route::get('/api/deleteService/{name}', [MainController::class, 'deleteService']);
Route::get('/api/changeService/{oldName}/{isHttps}/{newName}/{newURL}', [MainController::class, 'changeService']);
Route::get('/api/cpuUsage', [DockerCom::class, 'cpuUsage']);

?>