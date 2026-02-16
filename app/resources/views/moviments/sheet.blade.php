@extends('layouts.admin')
@section('content')
<div class="p-6 space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Planilha Financeira - Movimentações</h1>
        <a href="{{ route('moviments.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Nova Movimentação</a>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('moviments.sheet') }}" class="bg-white p-6 rounded-lg shadow-lg border">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium mb-1">Projeto</label>
                <select name="project_id" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Selecione um Projeto --</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Tipo</label>
                <select name="type" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos Tipos</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Data Inicial</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border rounded-lg p-3">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Data Final</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border rounded-lg p-3">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-500 text-white py-3 px-4 rounded-lg hover:bg-blue-600 font-medium">Filtrar</button>
                @if(request()->hasAny(['project_id', 'type', 'date_from', 'date_to']))
                    <a href="{{ route('moviments.sheet') }}" class="bg-gray-500 text-white py-3 px-4 rounded-lg hover:bg-gray-600 font-medium text-sm">Limpar</a>
                @endif
            </div>
        </div>
    </form>

    {{-- TOTais GLOBAIS (NOVO) --}}
    @if(request('project_id'))
    @if($projects->isNotEmpty())
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 bg-gradient-to-r from-blue-50 to-indigo-100 rounded-xl shadow-lg">
        <div class="text-center">
            <div class="text-3xl font-bold text-blue-600">
                R$ {{ number_format(($projects->where('id', request('project_id'))->first()->initial_budget ?? 0) + $totalRevenuesGlobal, 2, ',', '.') }}
            </div>
            <div class="text-sm text-gray-600 mt-1">Orçamento + Receitas (R$ {{ number_format($totalRevenuesGlobal, 2, ',', '.') }})</div>
        </div>
        <div class="text-center">
            <div class="text-3xl font-bold text-red-600">-R$ {{ number_format($totalExpensesGlobal, 2, ',', '.') }}</div>
            <div class="text-sm text-gray-600 mt-1">Total Despesas</div>
        </div>
        <div class="text-center border-l-4 border-green-200 pl-6">
            <div class="text-4xl font-bold text-green-600">
                R$ {{ number_format(($projects->where('id', request('project_id'))->first()->initial_budget ?? 0) + $totalRevenuesGlobal - $totalExpensesGlobal, 2, ',', '.') }}
            </div>
            <div class="text-sm text-gray-600 mt-1">Saldo Líquido Filtrado</div>
        </div>
    </div>
    @endif

    {{-- Tabela --}}
    @php
    // Projeto atual selecionado
    $currentProject = $projects->where('id', request('project_id'))->first();
    $runningBalance = $currentProject->initial_budget ?? 0; // saldo inicial
@endphp
    <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                <tr>
                    <th class="p-4 text-left font-semibold text-gray-900">Data</th>
                    <th class="p-4 text-left font-semibold text-gray-900">Descrição</th>
                    <th class="p-4 text-left font-semibold text-gray-900">Projeto Origem</th>
                    <th class="p-4 text-left font-semibold text-gray-900">Projeto Destino</th>
                    <th class="p-4 text-left font-semibold text-gray-900">Tipo</th>
                    <th class="p-4 text-right font-semibold text-gray-900">Valor (R$)</th>
                    <th class="p-4 text-right font-semibold text-gray-900">Saldo Projeto</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
    @forelse($moviments as $moviment)
        @php
            // Entrada (id 1) adiciona, Saída (id 2) subtrai
            if ($moviment->typeMoviment->id == 1) {
                $runningBalance += $moviment->amount;
            } elseif ($moviment->typeMoviment->id == 2) {
                $runningBalance -= $moviment->amount;
            }
        @endphp
        <tr class="hover:bg-gray-50 transition-all">
            <td class="p-4 font-medium">{{ $moviment->moviment_date->format('d/m/Y') }}</td>
            <td class="p-4 max-w-xs truncate">{{ $moviment->description ?? '—' }}</td>
            <td class="p-4">
                <a href="{{ route('projects.show', $moviment->projectRel->id) }}" class="text-blue-600 hover:underline font-medium">
                    {{ $moviment->projectRel->name }}
                </a>
            </td>
            <td class="p-4">
                @if($moviment->to_project_id && $moviment->toProject)
                    {{ $moviment->toProject->name }}
                @else
                    —
                @endif
            </td>
            <td class="p-4">
                <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium
                    @if($moviment->typeMoviment->id == 1) bg-green-100 text-green-800
                    @elseif($moviment->typeMoviment->id == 2) bg-red-100 text-red-800
                    @else bg-yellow-100 text-yellow-800 @endif">
                    {{ $moviment->typeMoviment->name }}
                </span>
            </td>
            <td class="p-4 text-right font-bold text-xl
                @if($moviment->typeMoviment->id == 1) text-green-600
                @else text-red-600 @endif">
                R$ {{ number_format($moviment->amount, 2, ',', '.') }}
            </td>

            {{-- Saldo corrente após esta linha --}}
            <td class="p-4 text-right font-mono font-bold
                @if($runningBalance >= 0) text-green-700 @else text-red-700 @endif">
                R$ {{ number_format($runningBalance, 2, ',', '.') }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="p-12 text-center text-gray-500 text-lg">
                Nenhuma movimentação encontrada.
            </td>
        </tr>
    @endforelse
</tbody>
            <tfoot class="bg-gradient-to-r from-emerald-50 to-green-100 border-t-4 border-green-200">
                <tr>
                    <td colspan="5" class="p-4 text-right font-bold text-lg text-gray-900">Total Entradas Visíveis:</td>
                    <td colspan="2" class="p-4 text-right font-bold text-2xl text-green-700" id="total-entradas">R$ 0,00</td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Paginação --}}
    <div class="flex justify-center mt-8">
        {{ $moviments->appends(request()->query())->links() }}
    </div>
    @else
    <div class="mt-8 p-6 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 rounded">
        Selecione um projeto para visualizar a planilha financeira detalhada.
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const rows = document.querySelectorAll('tbody tr');
    let total = 0;
    rows.forEach(row => {
        if (row.querySelector('.text-green-800')) {  // Verde = entrada (type 1)
            const valorText = row.cells[5].textContent.match(/[\d.,]+/)[0]
                .replace(/\./g, '').replace(',', '.');
            total += parseFloat(valorText) || 0;
        }
    });
    document.getElementById('total-entradas').textContent = 
        total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
});

</script>
@endpush
@endsection
