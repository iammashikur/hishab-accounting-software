<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EarningController;
use App\Http\Controllers\Api\ExpenceController;
use App\Http\Controllers\Api\LoanPaymentController;
use App\Http\Controllers\Api\LoanLoanPaymentsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('earnings', EarningController::class);

        Route::apiResource('expences', ExpenceController::class);

        Route::apiResource('loans', LoanController::class);

        // Loan Loan Payments
        Route::get('/loans/{loan}/loan-payments', [
            LoanLoanPaymentsController::class,
            'index',
        ])->name('loans.loan-payments.index');
        Route::post('/loans/{loan}/loan-payments', [
            LoanLoanPaymentsController::class,
            'store',
        ])->name('loans.loan-payments.store');

        Route::apiResource('loan-payments', LoanPaymentController::class);

        Route::apiResource('users', UserController::class);
    });
