<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('/map', [PostController::class, 'map'])->name('posts.map');
Route::get('/', [PostController::class, 'main'])->name('posts.main');
Route::get('/show', [PostController::class, 'show'])->name('posts.show');
Route::get('/edit', [PostController::class, 'show'])->name('posts.show');
Route::get('/delete', [PostController::class, 'show'])->name('posts.show');

require __DIR__.'/auth.php';
