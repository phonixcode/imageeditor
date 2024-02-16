<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ImageEditorController;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [ImageEditorController::class, 'cleanupImageView'])->name('cleanup.view');
Route::post('/cleanup-image', [ImageEditorController::class, 'cleanupImage'])->name('cleanupImage');
Route::get('/remove-background-image', [ImageEditorController::class, 'removeBackgroundView'])->name('removeBackground.view');
Route::post('/remove-background-image', [ImageEditorController::class, 'removeBackground'])->name('removeBackground');



Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'login_submit'])->name('login.submit');


Route::group(['middleware' => 'auth', 'preventBackHistory'], function () {
    Route::get('/api-key-settings', [AdminController::class, 'index'])->name('api.key.setting');
    Route::post('/update-api-key', [AdminController::class, 'updateApiKey'])->name('update.api.key');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

