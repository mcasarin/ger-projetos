<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class TaskCalendarController extends Controller
{
    public function calendar (Request $request)
    {
        $projectId = $request->get('project_id');
    $userId    = $request->get('user_id');
    $date      = $request->get('date');

    // Definindo data atual ou a data fornecida para o calendário
    $currentDate = $date ?: now()->toDateString();
    
    $dateObj = \Carbon\Carbon::parse($date ?: now()->toDateString());
    $startOfMonth = $dateObj->copy()->startOfMonth();
    $endOfMonth   = $dateObj->copy()->endOfMonth();

    // Query base com relacionamentos
    $query = Task::with(['project', 'user']);

    // Filtros por projeto/usuário
    if (!empty($projectId)) {
        $query->where('project_id', $projectId);
    }
    if (!empty($userId)) {
        $query->where('owner_id', $userId); // ou 'owner_id' conforme sua model
    }

    // APENAS tarefas que se sobreponham ao mês visível
    $query->where(function ($q) use ($startOfMonth, $endOfMonth) {
        $q->whereBetween('start_date', [$startOfMonth, $endOfMonth])
          ->orWhereBetween('due_date', [$startOfMonth, $endOfMonth])
          ->orWhere(function ($q2) use ($startOfMonth, $endOfMonth) {
              $q2->where('start_date', '<=', $startOfMonth)
                 ->where('due_date', '>=', $endOfMonth);
          });
    });

    $tasks = $query->orderBy('start_date')->get();

    $projects = Project::orderBy('name')->get();
    $users    = User::orderBy('name')->get();

        $menu = 'tasks-calendar';

        return view('tasks.calendar', compact(
            'tasks',
            'projects',
            'users',
            'projectId',
            'userId',
            'dateObj',
            'startOfMonth',
            'endOfMonth',
            'currentDate',
            'menu'
        ));
    }
}
