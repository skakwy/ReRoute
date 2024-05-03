<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\DockerCom;
use App\Http\Middleware\CheckUserAuth;



//login not auth protected
Route::get('/login/{failed?}', [MainController::class, 'loginPage']);
Route::get('/api/login/{name}/{password}', [MainController::class, 'login']);

//protected routes_____________________
Route::get('/', [MainController::class, 'dashboard'])->middleware(CheckUserAuth::class);
Route::get('/dashboard', [MainController::class, 'dashboard'])->middleware(CheckUserAuth::class);


//api

Route::get('/api/logout', [MainController::class, 'logout'])->middleware(CheckUserAuth::class);
Route::get('/api/addService/{name}/{ip}/{isHttps}', [MainController::class, 'addService'])->middleware(CheckUserAuth::class);
Route::get('/api/deleteService/{name}', [MainController::class, 'deleteService'])->middleware(CheckUserAuth::class);
Route::get('/api/changeService/{oldName}/{isHttps}/{newName}/{newURL}', [MainController::class, 'changeService'])->middleware(CheckUserAuth::class);
Route::get('/api/cpuUsage', [DockerCom::class, 'cpuUsage'])->middleware(CheckUserAuth::class);

?>