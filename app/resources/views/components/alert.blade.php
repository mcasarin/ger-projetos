
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: "success",
                title: "Sucesso",
                text: "{{ session('success') }}"
            });
        });
    </script>
       
    @endif
    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: "error",
                title: "Erro!",
                text: "{{ session('error') }}"
            });
        });
    </script>
    @endif

    @if ($errors->any())
    @php
    $message = '';
    foreach ($errors->all() as $error) {
        $message .= $error . '<br>';
    }
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: "error",
                title: "Erro!",
                html: "{!! $message !!}" // html para resolver a quebra de linha
            });
        });
    </script>
    @endif