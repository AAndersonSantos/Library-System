<?php
namespace Domain\Repositories;

use Domain\Models\Usuario;

class UsuarioRepository {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function add(Usuario $usuario) {
        $stmt = $this->connection->prepare('INSERT INTO usuarios (nome, sobrenome, data_de_nascimento, matricula) VALUES (:nome, :sobrenome, :data_de_nascimento, :matricula)');

        $stmt->bindValue(':nome', $usuario->getNome());
        $stmt->bindValue(':sobrenome', $usuario->getSobrenome());
        $stmt->bindValue(':data_de_nascimento', $usuario->getDataDeNascimento());
        $stmt->bindValue(':matricula', $usuario->getMatricula());
        $stmt->execute();
    }

    public function listarUsuarios() {
        $result = $this->connection->query('SELECT * FROM usuarios');
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteUsuario($id) {
        $stmt = $this->connection->prepare('DELETE FROM usuarios WHERE id = :id');
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function updateUsuario($id, Usuario $usuario) {
        $stmt = $this->connection->prepare('UPDATE usuarios SET nome = :nome, sobrenome = :sobrenome, data_de_nascimento = :data_de_nascimento, matricula = :matricula WHERE id = :id');
        $stmt->bindValue(':nome', $usuario->getNome());
        $stmt->bindValue(':sobrenome', $usuario->getSobrenome());
        $stmt->bindValue(':data_de_nascimento', $usuario->getDataDeNascimento());
        $stmt->bindValue(':matricula', $usuario->getMatricula());
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
