<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ImageController;
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

    Route::get('/answers/{id}/edit', [AnswerController::class, 'edit'])->name('answers.edit');

    Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('questions.destroy');

    Route::delete('/answers/{id}', [AnswerController::class, 'destroy'])->name('answers.destroy');

    Route::put('/questions/{id}', [QuestionController::class, 'update'])->name('questions.update');

    Route::put('/answers/{id}', [AnswerController::class, 'update'])->name('answers.update');

    Route::get('/posts/create', [QuestionController::class, 'create'])->name('questions.create');

    Route::post('/comments', [AnswerController::class, 'store'])->name('comments.store');

    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');

    //image upload
    Route::get('/upload', [ImageController::class, 'showUploadForm'])->name('upload.form');

    Route::post('/upload', [ImageController::class, 'uploadImage'])->name('upload.image');

    Route::get('/images', [ImageController::class, 'index'])->name('images.index');

    Route::delete('/images/{id}', [ImageController::class, 'destroy'])->name('images.destroy');

    //edit tag auth
    Route::get('/tags/edit', [TagController::class, 'index'])->name('tags.index');

    // Route::put('/tags/update', [TagController::class, 'update'])->name('tags.update');

    Route::delete('/tags/{id}', [TagController::class, 'destroy'])->name('tags.destroy');

    Route::put('/tags/{id}', [TagController::class, 'update'])->name('tags.update');

    // Route::get('/tags/create', [TagController::class, 'create'])->name('tags.create');

    Route::post('/tags/store', [TagController::class, 'store'])->name('tags.store');

});


Route::get('/', [QuestionController::class, 'main'])->name('questions.main');

Route::get('/questions/{id}', [QuestionController::class, 'show'])->name('questions.show');

Route::get('/map', [MapController::class, 'index'])->name('map.index');

Route::get('/map/realtimemode', [MapController::class, 'realTimeMode'])->name('map.realtimemode');

Route::get('/map/realtimemode/tag/{tag}', [MapController::class, 'filterByTagRealTimeMode'])->name('map.filterByTagRealTimeMode');

Route::get('/map/streetview', [MapController::class, 'streetview'])->name('map.streetview');

Route::get('/questions/tag/{tag}', [QuestionController::class, 'filterByTag'])->name('questions.filterByTag');

Route::get('/map/tag/{tag}', [MapController::class, 'filterByTag'])->name('map.filterByTag');


require __DIR__ . '/auth.php';
