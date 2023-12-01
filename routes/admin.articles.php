<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::resources([
    'roles'=> RoleController::class ,
    'users'=> UserController::class,
    'categories'=> CategoryController::class
]);
Route::get('generate_temp_link',[UserController::class,'generate_temp_link'])->name('generate_temp_link') ;
Route::get('show_temp_link',[UserController::class,'show_temp_link'])->name('show_temp_link') ;
Route::get('/' , function () 
{
    return view('admin.index');
}) ;
