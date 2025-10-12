<?php

use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\StatusProjsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Projetos Rota de projetos agrupados, refatorada com prefixo
Route::prefix('project')->group(function (){
    Route::get('/',[ProjectsController::class, 'index'])->name('projects.index');
    Route::get('/create',[ProjectsController::class, 'create'])->name('projects.create');
    Route::post('/',[ProjectsController::class, 'store'])->name('projects.store');
    Route::get('/{project}',[ProjectsController::class, 'show'])->name('projects.show');
    Route::get('/{project}/edit',[ProjectsController::class, 'edit'])->name('projects.edit');
    Route::put('/{project}',[ProjectsController::class, 'update'])->name('projects.update');
    Route::delete('/{project}',[ProjectsController::class, 'destroy'])->name('projects.destroy');
});
// Rotas de usuários
Route::prefix('user')->group(function (){
    Route::get('/',[UsersController::class, 'index'])->name('users.index');
    Route::get('/create',[UsersController::class, 'create'])->name('users.create');
    Route::post('/',[UsersController::class, 'store'])->name('users.store');
    Route::get('/{user}',[UsersController::class, 'show'])->name('users.show');
    Route::get('/{user}/edit',[UsersController::class, 'edit'])->name('users.edit');
    Route::put('/{user}',[UsersController::class, 'update'])->name('users.update');
});
// Rotas de status dos projetos
Route::prefix('status-proj')->group(function (){
    Route::get('/',[StatusProjsController::class, 'index'])->name('status_projs.index');
    Route::get('/create',[StatusProjsController::class, 'create'])->name('status_projs.create');
    Route::post('/',[StatusProjsController::class, 'store'])->name('status_projs.store');
});
