<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    // Listar todos os projetos
    public function index() {
        //Carregar a view
        return view('projects.index');
    }
}
