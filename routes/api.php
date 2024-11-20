<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PrestasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/profile', [HomeController::class, 'show']);
Route::middleware('auth:sanctum')->get('/ekskul', [HomeController::class, 'listEktrakurikuler']);
Route::middleware('auth:sanctum')->post('/registEkstra', [HomeController::class, 'registEKtra']);
Route::middleware('auth:sanctum')->get('/myKelas', [HomeController::class, 'myListEkstrakurikuler']);
Route::middleware('auth:sanctum')->get('/absen', [HomeController::class, 'inputKodeAbsen']);
Route::middleware('auth:sanctum')->get('/mysession', [HomeController::class, 'mySession']);
Route::middleware('auth:sanctum')->get('/mysession', [HomeController::class, 'mySession']);
Route::get('/pengumuman', [HomeController::class, 'showAllAnnouncement']);
Route::middleware('auth:sanctum')->get('/pengumuman/detail', [HomeController::class, 'showDetailAnnounc']);

Route::middleware('auth:sanctum')->post('/buat-sertif', [PrestasiController::class, 'prestasiStore']);
Route::middleware('auth:sanctum')->get('/prestasi', [HomeController::class, 'showMySertif']);
Route::middleware('auth:sanctum')->get('/prestasi/detail', [HomeController::class, 'detailSertif']);

// Route::middleware('auth:sanctum')->get('/getAbsentSessions', [HomeController::class, 'getAbsentSessions']);
