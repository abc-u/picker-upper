<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;

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
    Route::get('/profile/index', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/questions/{id}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    Route::put('/questions/{id}', [QuestionController::class, 'update'])->name('questions.update');
    Route::get('/posts/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/comments', [AnswerController::class, 'store'])->name('comments.store');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
});


Route::get('/', [QuestionController::class, 'main'])->name('questions.main');

Route::get('/questions/{id}', [QuestionController::class, 'show'])->name('questions.show');

Route::get('/map', [MapController::class, 'index'])->name('map.index');

Route::get('/questions/tag/{tag}', [QuestionController::class, 'filterByTag'])->name('questions.filterByTag');

Route::get('/map/tag/{tag}', [MapController::class, 'filterByTag'])->name('map.filterByTag');


require __DIR__ . '/auth.php';
