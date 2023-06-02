<?php

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['as' => 'quizzes.', 'prefix' => '/quizzes'], function() {
    Route::get('', [QuizController::class, 'index'])->name('index');

    Route::get('/{id}', [QuizController::class, 'show'])->name('get');
});

Route::group(['as' => 'questions.', 'prefix' => '/questions'], function() {
    Route::get('', [QuestionController::class, 'index'])->name('index');

    Route::get('/{id}', [QuestionController::class, 'show'])->name('get');
});
