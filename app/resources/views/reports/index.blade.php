@extends('layouts.admin')
@section('content')
<div class="p-6 space-y-6">
    {{-- Título e breadcrumb --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Relatórios - Logs de Auditoria</h1>
    </div>

    {{-- Filtros de busca --}}
    <div class="bg-white shadow-sm rounded-lg p-4">
        {{-- GET para manter compatível com paginação e facilitar compartilhamento de URL --}}
        <form method="GET" action="{{ route('reports.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Filtro por usuário --}}
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700">Usuário</label>
                <select name="user_id" id="user_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Todos</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}"
                            {{ $filters['user_id'] == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filtro por data inicial --}}
            <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700">Data inicial</label>
                <input type="date" name="date_from" id="date_from"
                       value="{{ $filters['date_from'] }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            {{-- Filtro por data final --}}
            <div>
                <label for="date_to" class="block text-sm font-medium text-gray-700">Data final</label>
                <input type="date" name="date_to" id="date_to"
                       value="{{ $filters['date_to'] }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            {{-- Filtro por evento --}}
            <div>
                <label for="event" class="block text-sm font-medium text-gray-700">Evento</label>
                <select name="event" id="event"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Todos</option>
                    @foreach($eventOptions as $event)
                        <option value="{{ $event }}"
                            {{ $filters['event'] == $event ? 'selected' : '' }}>
                            {{ ucfirst($event) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Botões de ação (buscar / limpar) --}}
            <div class="md:col-span-4 flex items-end justify-end space-x-2">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md text-white text-sm font-medium hover:bg-blue-700">
                    Filtrar
                </button>

                {{-- Botão de limpar filtros: volta para rota sem query string --}}
                <button type="button" id="btn-clear-filters"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md text-gray-700 text-sm font-medium hover:bg-gray-300">
                    Limpar
                </button>
            </div>
        </form>
    </div>

    {{-- Tabela de logs --}}
    <div class="bg-white shadow-sm rounded-lg p-4 overflow-x-auto">
        @if($logs->count() === 0)
            <p class="text-gray-500 text-sm">Nenhum log encontrado para os filtros informados.</p>
        @else
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left font-medium text-gray-700">Data/Hora</th>
                    <th class="px-3 py-2 text-left font-medium text-gray-700">Usuário</th>
                    <th class="px-3 py-2 text-left font-medium text-gray-700">Evento</th>
                    <th class="px-3 py-2 text-left font-medium text-gray-700">Modelo</th>
                    <th class="px-3 py-2 text-left font-medium text-gray-700">ID Registro</th>
                    <th class="px-3 py-2 text-left font-medium text-gray-700">Detalhes</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @foreach($logs as $log)
                    <tr>
                        {{-- Data/hora em ordem desc (já vem do controller) --}}
                        <td class="px-3 py-2 whitespace-nowrap">
                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                        </td>

                        {{-- Usuário relacionado (belongsTo User) --}}
                        <td class="px-3 py-2 whitespace-nowrap">
                            {{ optional($log->user)->name ?? 'N/D' }}
                        </td>

                        {{-- Evento: created, updated, deleted, warning, fail, etc. --}}
                        <td class="px-3 py-2 whitespace-nowrap">
                            @php
                                $badgeColor = 'bg-gray-200 text-gray-800';
                                if (in_array($log->event, ['created', 'restored', 'login'])) {
                                    $badgeColor = 'bg-green-100 text-green-800';
                                } elseif (in_array($log->event, ['updated'])) {
                                    $badgeColor = 'bg-blue-100 text-blue-800';
                                } elseif (in_array($log->event, ['deleted', 'warning', 'error', 'fail', 'logout'])) {
                                    $badgeColor = 'bg-red-100 text-red-800';
                                }
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeColor }}">
                                {{ strtoupper($log->event) }}
                            </span>
                        </td>

                        {{-- Modelo auditado (auditable_type) --}}
                        <td class="px-3 py-2 whitespace-nowrap">
                            {{-- Mostra só o "short name" da classe --}}
                            @php
                                $type = class_basename($log->auditable_type);
                            @endphp
                            {{ $type ?? 'N/D' }}
                        </td>

                        {{-- ID do registro auditado --}}
                        <td class="px-3 py-2 whitespace-nowrap">
                            {{ $log->auditable_id ?? 'N/D' }}
                        </td>

                        {{-- Detalhes resumidos (ex: campos alterados) --}}
                        <td class="px-3 py-2">
                            {{-- Exemplo simples: lista chaves alteradas (new_values) --}}
                            @php
                                $newValues = $log->new_values ?? [];
                                $oldValues = $log->old_values ?? [];
                                $changedKeys = array_unique(array_merge(array_keys($newValues), array_keys($oldValues)));
                            @endphp

                            @if(!empty($changedKeys))
                                <span class="text-xs text-gray-700">
                                    Campos: {{ implode(', ', $changedKeys) }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400">Sem detalhes</span>
                            @endif

                            {{-- Se quiser, adicione um botão/modal para ver JSON completo --}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{-- Paginação --}}
            <div class="mt-4">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
    {{-- JS separado em arquivo próprio para manter a view limpa --}}
    <script src="{{ asset('js/audit-logs.js') }}"></script>
@endpush
