<?php

use Illuminate\Support\Facades\Route;
use App\Models\Painters;
use App\Admin\Controllers\PainterController;
use App\Admin\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/painters', function () {
//     $painters = Painters::all();
//     return view('painters.index', compact('painters'));
// });

// Route::delete('/admin/painters/{id}', [App\Admin\Controllers\PainterController::class, 'destroy']);


Route::delete('/admin/painters/{id}', [PainterController::class, 'destroy']);
Route::delete('/admin/painters/{id}/force-delete', [PainterController::class, 'forceDelete']);
// Route::edit('/admin/painters/{id}/restore', [PainterController::class, 'restore']);
Route::put('/admin/painters/{id}/edit', [PainterController::class, 'edit'])->name('painters')->middleware('auth');
//Route::post('/admin/painters/{id}/update', [PainterController::class, 'update'])->name('painters.update')->middleware('auth');
Route::get('/tests/{id}/qrcode/download', [TestController::class, 'downloadQrCode'])->name('admin.tests.qrcode.download');
