<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Exception;

class DatabaseManagement extends Command
{
    // Assinatura do comando para uso no terminal
    protected $signature = 'db:manage {action : backup ou restore} {--file= : Nome do arquivo para restauração}';

    protected $description = 'Gerencia Backup e Restore do MariaDB 10.11';

    public function handle()
    {
        $action = $this->argument('action');

        if ($action === 'backup') {
            return $this->runBackup();
        }

        if ($action === 'restore') {
            return $this->runRestore();
        }

        $this->error("Ação inválida! Use 'backup' ou 'restore'.");
    }

    /**
     * Executa o Backup usando mariadb-dump (nativo MariaDB)
     */
    protected function runBackup()
    {
        $filename = "backup-" . now()->format('Y-m-d_H-i-s') . ".sql";
        $path = storage_path("app/backups/{$filename}");

        // Garante que o diretório existe
        if (!file_exists(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        $this->info("Iniciando backup: {$filename}...");

        // Comando otimizado para MariaDB 10.11
        $command = sprintf(
            'mariadb-dump --user=%s --password=%s --host=%s --ssl=0 %s > %s',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.host'),
            config('database.connections.mysql.database'),
            $path
        );

        $process = Process::run($command);

        if ($process->successful()) {
            $this->info("Backup concluído com sucesso em: {$path}");
            return 0;
        }

        $this->error("Erro no backup: " . $process->errorOutput());
        return 1;
    }

    /**
     * Executa o Restore do banco de dados
     */
    protected function runRestore()
    {
        $backupDir = storage_path("app/backups");
    
        // Se não passou o arquivo via --file, vamos listar os existentes
        $file = $this->option('file');

        if (!$file) {
            $files = collect(scandir($backupDir))
                ->filter(fn($f) => str_ends_with($f, '.sql'))
                ->values();

            if ($files->isEmpty()) {
                $this->error("Nenhum arquivo .sql encontrado em {$backupDir}");
                return 1;
            }

            // Cria um menu de escolha no terminal
            $file = $this->choice(
                'Qual backup deseja restaurar?',
                $files->toArray(),
                $files->count() - 1 // Sugere o último por padrão
            );
        }

        $fullPath = "{$backupDir}/{$file}";

        if (!file_exists($fullPath)) {
            $this->error("Arquivo não encontrado: {$fullPath}");
            return 1;
        }

        if (!$this->confirm("Deseja restaurar o backup [{$file}]? Isso apagará os dados atuais!")) {
            return 0;
        }

        $this->info("Restaurando banco de dados...");

        $command = sprintf(
            'mariadb-dump --user=%s --password=%s --host=%s --ssl=0 %s < %s',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.host'),
            config('database.connections.mysql.database'),
            $fullPath
        );

        $process = Process::run($command);

        if ($process->successful()) {
            $this->info("Sucesso: O banco de dados foi restaurado.");
            return 0;
        }

        $this->error("Falha no restore: " . $process->errorOutput());
        return 1;
    }
}