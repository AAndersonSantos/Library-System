<?php
namespace Domain\Models;

class Usuario extends Pessoa {
    private string $matricula;

    public function __construct(string $nome, string $sobrenome, string $dataDeNascimento, string $matricula) {
        parent::__construct($nome, $sobrenome, $dataDeNascimento,);
        $this->matricula = $matricula;
    }

    public function getMatricula() {
        return $this->matricula;
    }
}
