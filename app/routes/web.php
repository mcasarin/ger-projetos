<?php

use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserStatusController;
use App\Http\Controllers\StatusProjsController;
use App\Http\Controllers\StatusTaskController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\MovimentsController;
use App\Http\Controllers\TypeMovimentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\PermissionsController;
use Illuminate\Support\Facades\Route;

// Rotas publicas
// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Tela de login
Route::get('/login', [AuthController::class, 'index'])->name('login');
// Processar dados de login
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
// Solicitar Link de reset de senha
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Backend de solicitação de link de reset de senha
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Formulário de reset de senha
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
// Backend de gravação de senha alterada
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');


// Grupo de rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Rotas de Profile
    Route::prefix('profile')->group(function (){
        Route::get('/',[ProfilesController::class, 'show'])->name('profiles.show');
        Route::get('/{user}/edit',[ProfilesController::class, 'edit'])->name('profiles.edit');
        Route::put('/{user}',[ProfilesController::class, 'update'])->name('profiles.update');
        Route::get('/{user}/edit-password',[ProfilesController::class, 'editPassword'])->name('profiles.edit_password');
        Route::put('/{user}/update-password',[ProfilesController::class, 'updatePassword'])->name('profiles.update_password');
    });

    // Projetos Rota de projetos agrupados, refatorada com prefixo, refatorada para usar middleware de permissão
    Route::prefix('project')->group(function (){
        Route::get('/',[ProjectsController::class, 'index'])->name('projects.index')->middleware('permission:index-projects');
        Route::get('/create',[ProjectsController::class, 'create'])->name('projects.create')->middleware('permission:create-projects');
        Route::post('/',[ProjectsController::class, 'store'])->name('projects.store')->middleware('permission:create-projects');
        Route::get('/{project}',[ProjectsController::class, 'show'])->name('projects.show')->middleware('permission:show-projects');
        Route::get('/{project}/edit',[ProjectsController::class, 'edit'])->name('projects.edit')->middleware('permission:edit-projects');
        Route::put('/{project}',[ProjectsController::class, 'update'])->name('projects.update')->middleware('permission:edit-projects');
        Route::delete('/{project}',[ProjectsController::class, 'destroy'])->name('projects.destroy')->middleware('permission:destroy-projects');
    });
    // Rotas de usuários
    Route::prefix('user')->group(function (){
        Route::get('/',[UsersController::class, 'index'])->name('users.index')->middleware('permission:index-users');
        Route::get('/create',[UsersController::class, 'create'])->name('users.create')->middleware('permission:create-users');
        Route::post('/',[UsersController::class, 'store'])->name('users.store')->middleware('permission:create-users');
        Route::get('/{user}',[UsersController::class, 'show'])->name('users.show')->middleware('permission:show-users');
        Route::get('/{user}/edit',[UsersController::class, 'edit'])->name('users.edit')->middleware('permission:edit-users');
        Route::put('/{user}',[UsersController::class, 'update'])->name('users.update')->middleware('permission:edit-users');
        Route::get('/{user}/edit-password',[UsersController::class, 'editPassword'])->name('users.edit_password')->middleware('permission:edit-users-password');
        Route::put('/{user}/update-password',[UsersController::class, 'updatePassword'])->name('users.update_password')->middleware('permission:edit-users-password');
        Route::delete('/{user}',[UsersController::class, 'destroy'])->name('users.destroy')->middleware('permission:destroy-users');
    });
    // Rotas usuários Status
    Route::prefix('user-statuses')->group(function () {
        Route::get('/', [UserStatusController::class, 'index'])->name('user_statuses.index')->middleware('permission:index-user-status');
        Route::get('/create', [UserStatusController::class, 'create'])->name('user_statuses.create')->middleware('permission:create-user-status');
        Route::get('/{userStatus}', [UserStatusController::class, 'show'])->name('user_statuses.show')->middleware('permission:show-user-status');
        Route::post('/', [UserStatusController::class, 'store'])->name('user_statuses.store')->middleware('permission:create-user-status');
        Route::get('/{userStatus}/edit', [UserStatusController::class, 'edit'])->name('user_statuses.edit')->middleware('permission:edit-user-status');
        Route::put('/{userStatus}', [UserStatusController::class, 'update'])->name('user_statuses.update')->middleware('permission:edit-user-status');
        Route::delete('/{userStatus}', [UserStatusController::class, 'destroy'])->name('user_statuses.destroy')->middleware('permission:destroy-user-status');
    });
    // Rotas de status dos projetos
    Route::prefix('status-proj')->group(function (){
        Route::get('/',[StatusProjsController::class, 'index'])->name('status_projs.index')->middleware('permission:index-status-projs');
        Route::get('/create',[StatusProjsController::class, 'create'])->name('status_projs.create')->middleware('permission:create-status-projs');
        Route::post('/',[StatusProjsController::class, 'store'])->name('status_projs.store')->middleware('permission:create-status-projs');
    });
    // Rotas de status das tarefas
    Route::prefix('status-task')->group(function (){
        Route::get('/',[StatusTaskController::class, 'index'])->name('status_tasks.index');
        Route::get('/create',[StatusTaskController::class, 'create'])->name('status_tasks.create');
        Route::post('/',[StatusTaskController::class, 'store'])->name('status_tasks.store');
    });
    // Rotas de tasks
    Route::prefix('task')->group(function (){
        Route::get('/',[TasksController::class, 'index'])->name('tasks.index')->middleware('permission:index-tasks');
        Route::get('/create',[TasksController::class, 'create'])->name('tasks.create')->middleware('permission:create-tasks');
        Route::post('/',[TasksController::class, 'store'])->name('tasks.store')->middleware('permission:create-tasks');
        Route::get('/{task}',[TasksController::class, 'show'])->name('tasks.show')->middleware('permission:show-tasks');
        Route::get('/{task}/edit',[TasksController::class, 'edit'])->name('tasks.edit')->middleware('permission:edit-tasks');
        Route::put('/{task}',[TasksController::class, 'update'])->name('tasks.update')->middleware('permission:edit-tasks');
        Route::delete('/{task}',[TasksController::class, 'destroy'])->name('tasks.destroy')->middleware('permission:destroy-tasks');
    });
    // Rotas de tipos de movimentação
    Route::prefix('type-moviment')->group(function (){
        Route::get('/',[TypeMovimentController::class, 'index'])->name('type_moviments.index')->middleware('permission:index-type-moviments');
        Route::get('/create',[TypeMovimentController::class, 'create'])->name('type_moviments.create')->middleware('permission:create-type-moviments');
        Route::post('/',[TypeMovimentController::class, 'store'])->name('type_moviments.store')->middleware('permission:create-type-moviments');
    });
    // Rotas de Movimentações
    Route::prefix('moviments')->group(function (){
        Route::get('/',[MovimentsController::class, 'index'])->name('moviments.index')->middleware('permission:index-moviments');
        Route::get('/create',[MovimentsController::class, 'create'])->name('moviments.create')->middleware('permission:create-moviments');
        Route::post('/',[MovimentsController::class, 'store'])->name('moviments.store')->middleware('permission:create-moviments');
        Route::get('/{moviment}',[MovimentsController::class, 'show'])->name('moviments.show')->middleware('permission:show-moviments');
        Route::get('/{moviment}/edit',[MovimentsController::class, 'edit'])->name('moviments.edit')->middleware('permission:edit-moviments');
        Route::put('/{moviment}',[MovimentsController::class, 'update'])->name('moviments.update')->middleware('permission:edit-moviments');
        Route::delete('/{moviment}',[MovimentsController::class, 'destroy'])->name('moviments.destroy')->middleware('permission:destroy-moviments');
    });
    // Rotas de Papeis
    Route::prefix('roles')->group(function (){
        Route::get('/',[RolesController::class, 'index'])->name('roles.index')->middleware('permission:index-roles');
        Route::get('/create',[RolesController::class, 'create'])->name('roles.create')->middleware('permission:create-roles');
        Route::post('/',[RolesController::class, 'store'])->name('roles.store')->middleware('permission:create-roles');
        Route::get('/{role}',[RolesController::class, 'show'])->name('roles.show')->middleware('permission:show-roles');
        Route::get('/{role}/edit',[RolesController::class, 'edit'])->name('roles.edit')->middleware('permission:edit-roles');
        Route::put('/{role}',[RolesController::class, 'update'])->name('roles.update')->middleware('permission:edit-roles');
        Route::delete('/{role}',[RolesController::class, 'destroy'])->name('roles.destroy')->middleware('permission:destroy-roles');
    });

    
    // Rotas de Papeis e Permissões vinculadas
    Route::prefix('role-permissions')->group(function (){
        Route::get('/{role}',[RolePermissionController::class, 'index'])->name('role-permission.index')->middleware('permission:index-role-permission');
        Route::get('/{role}/{permission}',[RolePermissionController::class, 'update'])->name('role-permission.update')->middleware('permission:update-role-permission');
    });

    // Permissões de papeis
    Route::prefix('permissions')->group(function (){
        Route::get('/',[PermissionsController::class, 'index'])->name('permissions.index')->middleware('permission:index-permissions');
        Route::get('/create',[PermissionsController::class, 'create'])->name('permissions.create')->middleware('permission:create-permissions');
        Route::post('/',[PermissionsController::class, 'store'])->name('permissions.store')->middleware('permission:create-permissions');
        Route::get('/{permission}',[PermissionsController::class, 'show'])->name('permissions.show')->middleware('permission:show-permissions');
        Route::get('/{permission}/edit',[PermissionsController::class, 'edit'])->name('permissions.edit')->middleware('permission:edit-permissions');
        Route::put('/{permission}',[PermissionsController::class, 'update'])->name('permissions.update')->middleware('permission:edit-permissions');
        Route::delete('/{permission}',[PermissionsController::class, 'destroy'])->name('permissions.destroy')->middleware('permission:destroy-permissions');
    });
});
