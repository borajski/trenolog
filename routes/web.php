<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

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
    return view('welcome');
});

Auth::routes();

// Back routes //

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profile', function () {
    return view('layouts.back_layouts.users.user_profile');
});
Route::resource('users', UsersController::class);

Route::get('/exercises', function () {
    return view('layouts.back_layouts.exercises.index');
}); 
//Route::get('/exercises', [MusclesController::class, 'index']);



