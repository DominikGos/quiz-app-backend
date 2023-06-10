<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
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
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::group(['as' => 'quizzes.', 'prefix' => '/quizzes'], function() {
        Route::post('', [QuizController::class, 'store'])->name('store');

        Route::put('/{id}', [QuizController::class, 'update'])->name('update');

        Route::delete('/{id}', [QuizController::class, 'destroy'])->name('destroy');

        Route::post('/image', [QuizController::class, 'storeImage'])->name('image.store');

        Route::delete('/image', [QuizController::class, 'destroyImage'])->name('image.destroy');
    });

    Route::group(['as' => 'questions.', 'prefix' => '/questions'], function() {
        Route::post('', [QuestionController::class, 'store'])->name('store');

        Route::put('/{id}', [QuestionController::class, 'update'])->name('update');

        Route::delete('/{id}', [QuestionController::class, 'destroy'])->name('destroy');
    });

    Route::group(['as' => 'answers.', 'prefix' => '/answers'], function() {
        Route::post('', [AnswerController::class, 'store'])->name('store');

        Route::put('/{id}', [AnswerController::class, 'update'])->name('update');

        Route::delete('/{id}', [AnswerController::class, 'destroy'])->name('destroy');
    });

    Route::group(['as' => 'users.', 'prefix' => '/users'], function() {
        Route::put('/{id}', [UserController::class, 'update'])->name('update');

        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');

        Route::post('/image', [UserController::class, 'storeImage'])->name('image.store');

        Route::delete('/image', [UserController::class, 'destroyImage'])->name('image.destroy');
    });
});

Route::group(['as' => 'quizzes.', 'prefix' => '/quizzes'], function() {
    Route::get('', [QuizController::class, 'index'])->name('index');

    Route::get('/{id}', [QuizController::class, 'show'])->name('get');
});

Route::group(['as' => 'questions.', 'prefix' => '/questions'], function() {
    Route::get('/{id}', [QuestionController::class, 'show'])->name('get');
});

Route::group(['as' => 'answers.', 'prefix' => '/answers'], function() {
    Route::get('/{id}', [AnswerController::class, 'show'])->name('get');
});

Route::group(['as' => 'users.', 'prefix' => '/users'], function() {
    Route::get('', [UserController::class, 'index'])->name('index');

    Route::get('/{id}', [UserController::class, 'show'])->name('show');
});

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::post('/login', [LoginController::class, 'login'])->name('login');

