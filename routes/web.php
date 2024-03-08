<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EarningController;
use App\Http\Controllers\ExpenceController;
use App\Http\Controllers\LoanPaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
        if (Auth::check()) {
            return redirect('/dashboard');
        } else {
            return view('auth.login');
        }
});

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard', function () {


        //total earnings
        $total_earnings = DB::table('earnings')->sum('amount');
        $total_loans = DB::table('loans')->sum('amount');
        $total_expences = DB::table('expences')->sum('amount');
        $total_loan_payments = DB::table('loan_payments')->sum('amount');



        $pending_loans = $total_loans - $total_loan_payments;

        $total_balance = $total_earnings - $total_expences - $pending_loans;

        //this month earnings
        $this_month_earnings = DB::table('earnings')
            ->whereMonth('created_at', date('m'))
            ->sum('amount');

        //this month expences
        $this_month_expences = DB::table('expences')
            ->whereMonth('created_at', date('m'))
            ->sum('amount');


        return view('dashboard' , compact('total_earnings', 'total_loans', 'total_expences', 'total_loan_payments', 'pending_loans', 'total_balance', 'this_month_earnings', 'this_month_expences'));
    })
    ->name('dashboard');

Route::prefix('/')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::resource('earnings', EarningController::class);
        Route::resource('expences', ExpenceController::class);
        Route::resource('loans', LoanController::class);
        Route::resource('loan-payments', LoanPaymentController::class);
        Route::resource('users', UserController::class);
    });
