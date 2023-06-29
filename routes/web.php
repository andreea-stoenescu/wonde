<?php

use App\Http\Controllers\EmployeesController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [EmployeesController::class, 'index'])->name('employees');
Route::get('employees/{employee}', [EmployeesController::class, 'view'])->name('employee');
Route::get('employees/{employee}/{date}', [EmployeesController::class, 'viewLessonsByDate'])->name('employee-lessons');