<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
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

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/test', function() {
        echo 'Token works';
    });
});

Route::group(['as' => 'quizzes.', 'prefix' => '/quizzes'], function() {
    Route::get('', [QuizController::class, 'index'])->name('index');

    Route::get('/{id}', [QuizController::class, 'show'])->name('get');
});

Route::group(['as' => 'questions.', 'prefix' => '/questions'], function() {
    Route::get('', [QuestionController::class, 'index'])->name('index');

    Route::get('/{id}', [QuestionController::class, 'show'])->name('get');
});

Route::group(['as' => 'answers.', 'prefix' => '/answers'], function() {
    Route::get('', [AnswerController::class, 'index'])->name('index');

    Route::get('/{id}', [AnswerController::class, 'show'])->name('get');
});

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::post('/login', [LoginController::class, 'login'])->name('login');

