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
    return redirect('login');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'users', 'middleware'=> ['auth']], function(){
	Route::get('all',[UsersController::class, 'getAllUsers']);
	Route::post('add',[UsersController::class, 'addUser']);
	Route::get('add',[UsersController::class, 'getAddUser']);
	Route::get('edit/{id}',[UsersController::class, 'editUserPage']);
	Route::post('edit/{id}',[UsersController::class, 'editUser']);
	Route::get('delete/{id}',[UsersController::class, 'deleteUser']);
});
