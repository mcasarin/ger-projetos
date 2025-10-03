<div>
    <h2>Listagem de Status dos Projetos</h2>
    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif
</div>
