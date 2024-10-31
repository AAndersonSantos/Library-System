<?php
namespace Infrastructure\Database;

class Database {
    private $connection;
    private $databasePath;

    public function __construct() {
        $this->databasePath = __DIR__ . '/../../database.sqlite';
        $this->createDatabase();
        $this->connection = new \PDO('sqlite:' . $this->databasePath);

        if (!$this->connection) {
            die('Falha ao conectar ao banco de dados.');
        }

        $this->createTables();
    }

    private function createDatabase() {
        if (!file_exists($this->databasePath)) {
            touch($this->databasePath);
        }
    }

    private function createTables() {
        try {
            $this->connection->exec("
                CREATE TABLE IF NOT EXISTS livros (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    titulo TEXT,
                    autor TEXT,
                    isbn TEXT UNIQUE,
                    status TEXT CHECK( status IN ('Disponivel','Emprestado') ) DEFAULT 'Disponivel'
                );
            ");

            $this->connection->exec("
                CREATE TABLE IF NOT EXISTS usuarios (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    nome TEXT,
                    sobrenome TEXT,
                    data_de_nascimento TEXT,
                    matricula TEXT UNIQUE
                );
            ");

            $this->connection->exec("
                CREATE TABLE IF NOT EXISTS emprestimos (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    usuario_id INTEGER,
                    livro_id INTEGER,
                    data_emprestimo DATETIME,
                    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
                    FOREIGN KEY (livro_id) REFERENCES livros(id)
                );
            ");

        } catch (\Exception $e) {
            echo "Erro ao criar tabelas: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
