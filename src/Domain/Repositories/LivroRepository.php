<?php
namespace Domain\Repositories;

class LivroRepository {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function addLivro($titulo, $autor, $isbn) {
        $stmt = $this->connection->prepare("INSERT INTO livros (titulo, autor, isbn) VALUES (:titulo, :autor, :isbn)");
        $stmt->bindValue(':titulo', $titulo);
        $stmt->bindValue(':autor', $autor);
        $stmt->bindValue(':isbn', $isbn);
        $stmt->execute();
    }

    public function listarLivros() {
        $result = $this->connection->query("SELECT * FROM livros");
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->connection->prepare('DELETE FROM livros WHERE id = :id');
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update($id, $titulo, $autor, $isbn) {
        $stmt = $this->connection->prepare('UPDATE livros SET titulo = :titulo, autor = :autor, isbn = :isbn WHERE id = :id');
        $stmt->bindValue(':titulo', $titulo);
        $stmt->bindValue(':autor', $autor);
        $stmt->bindValue(':isbn', $isbn);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
