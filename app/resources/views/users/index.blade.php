<div>
    <h2>Lista de usuários</h2>
    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif
</div>
