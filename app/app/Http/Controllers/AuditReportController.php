<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AuditReport;
use App\Models\User;
use Illuminate\Support\Carbon;

class AuditReportController extends Controller
{
    /**
     * Lista de logs de auditoria (Relatórios/Logs).
     */
    public function index(Request $request)
    {
        $query = AuditReport::with(['user', 'auditable'])
            ->orderBy('created_at', 'desc') // mais novo primeiro
            ->orderBy('id', 'desc');        // empate por ID

        // Filtro por usuário (combo na view)
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }

        // Filtro por tipo de evento (created, updated, deleted, restored, login, logout, warning, error, fail, etc.)
        if ($request->filled('event')) {
            $query->where('event', $request->get('event'));
        }

        // Filtro por data (intervalo)
        if ($request->filled('date_from')) {
            $dateFrom = Carbon::createFromFormat('Y-m-d', $request->get('date_from'))->startOfDay();
            $query->where('created_at', '>=', $dateFrom);
        }

        if ($request->filled('date_to')) {
            $dateTo = Carbon::createFromFormat('Y-m-d', $request->get('date_to'))->endOfDay();
            $query->where('created_at', '<=', $dateTo);
        }

        $logs = $query->paginate(25)->appends($request->query());

        // Para o filtro de usuários (combo)
        $users = User::orderBy('name')->get(['id', 'name']);

        // Opções de eventos que você quer permitir no filtro.
        // Ajuste conforme seu uso real (created, updated, deleted, login, logout, warning, error, fail, etc.).
        $eventOptions = [
            'created',
            'updated',
            'deleted',
            'restored',
            'warning',
            'error',
            'fail',
            'login',
            'logout',
        ];

        return view('reports.index', [
            'logs'         => $logs,
            'users'        => $users,
            'eventOptions' => $eventOptions,
            'filters'      => [
                'user_id'   => $request->get('user_id'),
                'event'     => $request->get('event'),
                'date_from' => $request->get('date_from'),
                'date_to'   => $request->get('date_to'),
            ],
            'menu'         => 'audit-logs', // para marcar o item de menu ativo
        ]);
    }
}
