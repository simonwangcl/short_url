<?php

use App\Http\Controllers\ShortUrl\ShortUrlController;
use App\Http\Controllers\Test\TestController;
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

// url转短链接
Route::any('/urlToShortUrl', [ShortUrlController::class, 'urlToShortUrl']);
// 短链接转url并跳转
Route::any('/', [ShortUrlController::class, 'shortUrlToUrl']);


// 测试函数，方便后期调试
Route::any('/test', [TestController::class, 'index']);
