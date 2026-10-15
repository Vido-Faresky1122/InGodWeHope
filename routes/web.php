<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('index');
Route::get('/result', [ProductController::class, 'result'])->name('result');
Route::post('/store', [ProductController::class, 'store'])->name('store');
Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy');
Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
Route::put('/update/{id}', [ProductController::class, 'update'])->name('update');