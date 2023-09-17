<?php

use App\Http\Controllers\ImageController;
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

Route::get('/images', [ImageController::class, 'index']);

// Route to get a list of directories and files in a directory
// Route::get('images', 'ImageController@index');

// Route::get('/images', [ImageController::class, 'index']);

// Route to serve individual images
// Route::get('images/{path}', 'ImageController@show');

// Route::get('/images/{path}', [ImageController::class, 'show']);
