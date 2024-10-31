<?php
namespace Domain\Models;

class Emprestimo {
    private $livroId;
    private $usuarioId;
    private $dataEmprestimo;

    public function __construct(int $livroId, int $usuarioId) {
        $this->livroId = $livroId;
        $this->usuarioId = $usuarioId;
        $this->dataEmprestimo = new \DateTime();
    }

    public function getLivroId() {
        return $this->livroId;
    }

    public function getUsuarioId() {
        return $this->usuarioId;
    }

    public function getDataEmprestimo() {
        return $this->dataEmprestimo;
    }
}