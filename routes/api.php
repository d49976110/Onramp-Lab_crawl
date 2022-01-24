<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('crawl', 'App\Http\Controllers\CrawlController@GetContent');
Route::post('crawl/single', 'App\Http\Controllers\CrawlController@GetSingle');
Route::post('crawl/ScreenShot', 'App\Http\Controllers\CrawlController@GetScreenShot');
