<div>
    <h2>Cadastrar Projeto</h2>
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        @method('POST')
        <div>
            <label for="name">Nome do Projeto:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="description">Descrição:</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <div>
            <label for="initial_budget">Orçamento inicial</label>
            <input type="number" id="initial_budget" name="initial_budget" step="0.01" required>
        </div>
        <button type="submit">Cadastrar</button>
    </form>
</div>
