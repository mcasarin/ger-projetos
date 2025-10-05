<?php

use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\StatusProjsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Projetos
Route::get('/index-project',[ProjectsController::class, 'index'])->name('projects.index');
Route::get('/create-project',[ProjectsController::class, 'create'])->name('projects.create');
Route::post('/store-project',[ProjectsController::class, 'store'])->name('projects.store');
Route::get('/show-project/{project}',[ProjectsController::class, 'show'])->name('projects.show');
Route::get('/index-user',[UsersController::class, 'index'])->name('users.index');
Route::get('/create-user',[UsersController::class, 'create'])->name('users.create');
Route::post('/store-user',[UsersController::class, 'store'])->name('users.store');
Route::get('/index-status-proj',[StatusProjsController::class, 'index'])->name('status_projs.index');
Route::get('/create-status-proj',[StatusProjsController::class, 'create'])->name('status_projs.create');
Route::post('/store-status-proj',[StatusProjsController::class, 'store'])->name('status_projs.store');