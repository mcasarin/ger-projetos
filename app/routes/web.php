<?php

use App\Http\Controllers\ProjectsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Projetos
Route::get('/projects',[ProjectsController::class, 'index'])->name('projects.index');

