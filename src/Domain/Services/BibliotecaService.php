<?php
namespace Domain\Services;

use Infrastructure\Database\Database;
use Domain\Repositories\UsuarioRepository;
use Domain\Models\Usuario;

class BibliotecaService {
    private $usuarioRepository;

    public function __construct() {
        $database = new Database();
        $connection = $database->getConnection();
        
        $this->usuarioRepository = new UsuarioRepository($connection);
    }

    public function addUsuario(string $nome, string $sobrenome, string $dataDeNascimento, string $matricula) {
        $usuario = new Usuario($nome, $sobrenome, $dataDeNascimento, $matricula);
        $this->usuarioRepository->add($usuario);
    }

    public function listarUsuarios() {
        return $this->usuarioRepository->listarUsuarios();
    }

    public function deleteUsuario(int $id) {
        return $this->usuarioRepository->deleteUsuario($id);
    }

    public function updateUsuario(int $id, string $nome, string $sobrenome, string $dataDeNascimento, string $matricula) {
        $usuario = new Usuario($nome, $sobrenome, $dataDeNascimento, $matricula);
        return $this->usuarioRepository->updateUsuario($id, $usuario);
    }
}
