<?php

//use App\Http\Controllers\Api\ApiTokenController;
use App\Http\Controllers\Api\BookController;
use Illuminate\Support\Facades\Route;

// Route::post('/tokens', [ApiTokenController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    // Route::delete('/tokens/current', [ApiTokenController::class, 'destroy']);

    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::patch('/books/{book}', [BookController::class, 'update'])->name('books.patch');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
});
