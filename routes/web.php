<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\FoodsController;
use App\Http\Controllers\MealsController;

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

// BACK ROUTES//

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profile', function () {
    return view('layouts.back_layouts.users.user_profile');
});
Route::resource('users', UsersController::class);

// Food routes //
Route::resource('foods', FoodsController::class);
Route::get('/foods', [FoodsController::class, 'index']);
Route::post('/foods/{id}', [FoodsController::class, 'update'])->name('food.update');
Route::get('del_food/{id}',[FoodsController::class, 'destroy']);
Route::get('/food/{id}', [FoodsController::class, 'getFood']);
Route::get('/search-food', [FoodsController::class, 'search'])->name('search.food');


// Meal routes //
Route::resource('meals', MealsController::class);
Route::get('/meals', [MealsController::class, 'index']);
Route::get('meals/{{id}}', [MealsController::class, 'show'])->name('meal');

Route::get('/exercises', function () {
    return view('layouts.back_layouts.exercises.index');
}); 
//Route::get('/exercises', [MusclesController::class, 'index']);



