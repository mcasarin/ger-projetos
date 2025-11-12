<?php

use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\StatusProjsController;
use App\Http\Controllers\StatusTaskController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\MovimentsController;
use App\Http\Controllers\TypeMovimentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Tela de login
Route::get('/login', [AuthController::class, 'index'])->name('login');
// Processar dados de login
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// grupo de rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

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
        Route::get('/{user}/edit-password',[UsersController::class, 'editPassword'])->name('users.edit_password');
        Route::put('/{user}/update-password',[UsersController::class, 'updatePassword'])->name('users.update_password');
    });
    // Rotas de status dos projetos
    Route::prefix('status-proj')->group(function (){
        Route::get('/',[StatusProjsController::class, 'index'])->name('status_projs.index');
        Route::get('/create',[StatusProjsController::class, 'create'])->name('status_projs.create');
        Route::post('/',[StatusProjsController::class, 'store'])->name('status_projs.store');
    });
    // Rotas de status das tarefas
    Route::prefix('status-task')->group(function (){
        Route::get('/',[StatusTaskController::class, 'index'])->name('status_tasks.index');
        Route::get('/create',[StatusTaskController::class, 'create'])->name('status_tasks.create');
        Route::post('/',[StatusTaskController::class, 'store'])->name('status_tasks.store');
    });
    // Rotas de tasks
    Route::prefix('task')->group(function (){
        Route::get('/',[TasksController::class, 'index'])->name('tasks.index');
        Route::get('/create',[TasksController::class, 'create'])->name('tasks.create');
        Route::post('/',[TasksController::class, 'store'])->name('tasks.store');
        Route::get('/{task}',[TasksController::class, 'show'])->name('tasks.show');
        Route::get('/{task}/edit',[TasksController::class, 'edit'])->name('tasks.edit');
        Route::put('/{task}',[TasksController::class, 'update'])->name('tasks.update');
        Route::delete('/{task}',[TasksController::class, 'destroy'])->name('tasks.destroy');
    });
    // Rotas de tipos de movimentação
    Route::prefix('type-moviment')->group(function (){
        Route::get('/',[TypeMovimentController::class, 'index'])->name('type_moviments.index');
        Route::get('/create',[TypeMovimentController::class, 'create'])->name('type_moviments.create');
        Route::post('/',[TypeMovimentController::class, 'store'])->name('type_moviments.store');
    });
    // Rotas de Movimentações
    Route::prefix('moviments')->group(function (){
        Route::get('/',[MovimentsController::class, 'index'])->name('moviments.index');
        Route::get('/create',[MovimentsController::class, 'create'])->name('moviments.create');
        Route::post('/',[MovimentsController::class, 'store'])->name('moviments.store');
        Route::get('/{moviment}',[MovimentsController::class, 'show'])->name('moviments.show');
        Route::get('/{moviment}/edit',[MovimentsController::class, 'edit'])->name('moviments.edit');
        Route::put('/{moviment}',[MovimentsController::class, 'update'])->name('moviments.update');
        Route::delete('/{moviment}',[MovimentsController::class, 'destroy'])->name('moviments.destroy');
    });
});
