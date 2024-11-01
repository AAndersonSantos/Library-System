<?php

namespace Domain\Services;

use Infrastructure\Database\Database;
use Domain\Repositories\LivroRepository;
use Domain\Repositories\UsuarioRepository;
use Domain\Repositories\EmprestimoRepository;
use Domain\Models\Usuario;
use Domain\Models\Emprestimo; 

class BibliotecaService {
    private $livroRepository;
    private $usuarioRepository;
    private $emprestimoRepository;

    public function __construct() {
        $database = new Database();
        $connection = $database->getConnection();
        
        $this->livroRepository = new LivroRepository($connection);
        $this->usuarioRepository = new UsuarioRepository($connection);
        $this->emprestimoRepository = new EmprestimoRepository($connection);
    }

    //Emprestimo
    public function registrarEmprestimo(int $livroId, int $usuarioId) {
        $emprestimo = new Emprestimo($livroId, $usuarioId);
        $this->emprestimoRepository->salvarEmprestimo($emprestimo);
    }

    //Livros
    public function addLivro(string $titulo, string $autor, string $isbn) {
        $this->livroRepository->addLivro($titulo, $autor, $isbn);
    }

    public function listarLivros() {
        return $this->livroRepository->listarLivros();
    }

    public function deleteLivro(int $id) {
        return $this->livroRepository->delete($id);
    }

    public function updateLivro(int $id, string $titulo, string $autor, string $isbn) {
        return $this->livroRepository->update($id, $titulo, $autor, $isbn);
    }

    //Usuarios
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
