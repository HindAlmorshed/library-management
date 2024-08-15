<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\BookController;
use App\Http\Controllers\PatronController;
use App\Http\Controllers\Borrowing_RecordController;



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


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});


// Book
Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'book_details']);
Route::post('/books', [BookController::class, 'store']);
Route::put('/books/{id}', [BookController::class, 'update']);
Route::delete('/books/{id}', [BookController::class, 'destroy']);


// Patron
Route::get('/patrons', [PatronController::class, 'index']);
Route::get('/patrons/{id}', [PatronController::class, 'patron_details']);
Route::post('/patrons', [PatronController::class, 'store']);
Route::put('/patrons/{id}', [PatronController::class, 'update']);
Route::delete('/patrons/{id}', [PatronController::class, 'destroy']);


// Borrowing Record
Route::post('/borrow/{bookId}/patron/{patronId}', [Borrowing_RecordController::class, 'borrow_book']);
Route::put('/return/{bookId}/patron/{patronId}', [Borrowing_RecordController::class, 'return_book']);

