<?php
namespace Domain\Repositories;

use Domain\Models\Emprestimo;

class EmprestimoRepository {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function salvarEmprestimo(Emprestimo $emprestimo) {
        try {
            $stmt = $this->connection->prepare("
                INSERT INTO emprestimos (usuario_id, livro_id, data_emprestimo) 
                VALUES (:usuario_id, :livro_id, :data_emprestimo)
            ");
            
            $stmt->execute([
                'usuario_id' => $emprestimo->getUsuarioId(),
                'livro_id' => $emprestimo->getLivroId(),
                'data_emprestimo' => $emprestimo->getDataEmprestimo()->format('Y-m-d H:i:s')
            ]);

            $updateStmt = $this->connection->prepare("UPDATE livros SET status = 'Emprestado' WHERE id = :livro_id");
            $updateStmt->execute(['livro_id' => $emprestimo->getLivroId()]);

        } catch (\PDOException $e) {
            echo "Erro ao registrar empréstimo: " . $e->getMessage();
        }
    }
}
