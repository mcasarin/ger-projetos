@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-xl font-semibold text-gray-900 mb-4">Calendário de Tarefas</h1>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('tasks.calendar') }}" id="filters-form" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="project_id" class="block text-sm font-medium text-gray-700 mb-1">Projeto</label>
                <select name="project_id" id="project_id"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">Todos</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}"
                            {{ (string)$projectId === (string)$project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Usuário</label>
                <select name="user_id" id="user_id"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">Todos</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            {{ (string)$userId === (string)$user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Dia</label>
                <input type="date" name="date" id="date" value="{{ $currentDate }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Filtrar
                </button>
                <a href="{{ route('tasks.calendar') }}"
                    class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Limpar
                </a>
            </div>
        </div>
    </form>

    {{-- Calendário simples por dia do mês --}}
    @php
        $dateObj = \Carbon\Carbon::parse($currentDate);
        $startOfMonth = $dateObj->copy()->startOfMonth();
        $endOfMonth = $dateObj->copy()->endOfMonth();
    @endphp

    <div class="flex items-center justify-between mb-3">
        <div class="text-sm text-gray-700">
            <span class="font-medium">Mês:</span> {{ $dateObj->translatedFormat('F Y') }}
        </div>
        <div class="space-x-2">
            <button class="inline-flex items-center px-2 py-1 border border-gray-300 text-xs md:text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                id="prev-month">
                &laquo; Mês anterior
            </button>
            <button class="inline-flex items-center px-2 py-1 border border-gray-300 text-xs md:text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                id="next-month">
                Próximo mês &raquo;
            </button>
        </div>
    </div>

    {{-- Cabeçalho dias da semana --}}
    <div class="grid grid-cols-7 text-xs font-medium text-center text-gray-500 uppercase tracking-wide mb-1">
        <div>Dom</div>
        <div>Seg</div>
        <div>Ter</div>
        <div>Qua</div>
        <div>Qui</div>
        <div>Sex</div>
        <div>Sáb</div>
    </div>

    {{-- Grid 7 colunas (semana) --}}
    <div class="grid grid-cols-7 gap-px bg-gray-200 rounded-lg overflow-hidden text-xs md:text-sm">
        @php
            $startWeekDay = $startOfMonth->dayOfWeek; // 0 (Dom) ... 6 (Sáb)

            for ($i = 0; $i < $startWeekDay; $i++) {
                echo '<div class="bg-gray-50 h-24 md:h-32"></div>';
            }

            $currentDay = $startOfMonth->copy();
        @endphp

        @while ($currentDay->lte($endOfMonth))
            @php
                $dayKey  = $currentDay->format('Y-m-d');
                $isToday = $currentDay->isToday();
            @endphp

            <div class="bg-white h-24 md:h-32 p-1.5 md:p-2 flex flex-col border border-gray-100">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-semibold text-gray-700">
                        {{ $currentDay->day }}
                    </span>
                    @if ($isToday)
                        <span class="inline-flex items-center rounded-full px-1.5 py-0.5 text-[10px] font-medium bg-indigo-100 text-indigo-700">
                            hoje
                        </span>
                    @endif
                </div>

                <div class="space-y-1 overflow-y-auto">
                    @foreach ($tasks as $task)
                        @php
                            $start = \Carbon\Carbon::parse($task->start_date);
                            $due   = \Carbon\Carbon::parse($task->due_date ?? $task->start_date);
                            $isActive = $currentDay->toDateString() >= $start->toDateString() 
                                && $currentDay->toDateString() <= $due->toDateString();
                            
                            // Badge especial se termina hoje
                            $isEndingToday = $due->isToday();
                        @endphp


                        @if ($isActive)
                            <div class="rounded border-2 {{ $isEndingToday ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-blue-50' }} px-1.5 py-1">
                                <div class="text-[11px] font-semibold text-gray-800 truncate">
                                    <a href="{{ route('tasks.edit', ['task' => $task->id]) }}">{{ $task->description }}</a>
                                </div>
                                <div class="mt-0.5 text-[10px] text-gray-600 leading-tight">
                                    <div>Proj: {{ $task->project?->name ?? '—' }}</div>
                                    <div><b>{{ $task->user?->name ?? '—' }}</b></div>
                                    <div class="font-medium">
                                        {{ $start->format('d/m') }} → {{ $due->format('d/m') }}
                                    </div>
                                    @if ($task->closed_at)
                                        <div class="text-green-600">
                                            ✅ Encerrado: {{ \Carbon\Carbon::parse($task->closed_at)->format('d/m/Y') }}
                                        </div>
                                    @else
                                        <div class="text-orange-600">
                                            ⏳ Em aberto
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            @php
                $currentDay->addDay();
            @endphp
        @endwhile
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const prevBtn = document.getElementById('prev-month');
        const nextBtn = document.getElementById('next-month');
        const dateInput = document.getElementById('date');
        const form = document.getElementById('filters-form');

        if (!prevBtn || !nextBtn || !dateInput || !form) return;

        function changeMonth(offset) {
            const current = new Date(dateInput.value || new Date());
            current.setMonth(current.getMonth() + offset);

            const year  = current.getFullYear();
            const month = String(current.getMonth() + 1).padStart(2, '0');
            const day   = String(current.getDate()).padStart(2, '0');

            dateInput.value = `${year}-${month}-${day}`;
            form.submit();
        }

        prevBtn.addEventListener('click', function (e) {
            e.preventDefault();
            changeMonth(-1);
        });

        nextBtn.addEventListener('click', function (e) {
            e.preventDefault();
            changeMonth(1);
        });
    });
</script>
@endpush
