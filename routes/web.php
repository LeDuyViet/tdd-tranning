<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});
//Route::group(function() {})
Route::get('/task/show/{id}', [TaskController::class, 'show'])->name('task.show')->middleware('auth');
Route::get('/task', [TaskController::class, 'index'])->name('task.index');
Route::post('/task/store', [TaskController::class, 'store'])->name('task.store')->middleware('auth');
Route::get('task/create', [TaskController::class, 'create'])->name('task.create')->middleware('auth');
Route::get('task/update/{id}', [TaskController::class, 'edit'])->name('task.edit')->middleware('auth');
Route::put('task/update/{id}', [TaskController::class, 'update'])->name('task.update')->middleware('auth');
Route::delete('task/delete/{id}', [TaskController::class, 'destroy'])->name('task.delete')->middleware('auth');


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
