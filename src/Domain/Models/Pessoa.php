<?php
namespace Domain\Models;

class Pessoa {
    private $nome;
    private $sobrenome;
    private $dataDeNascimento;

    public function __construct(string $nome, string $sobrenome, string $dataDeNascimento) {
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->dataDeNascimento = $dataDeNascimento;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getSobrenome() {
        return $this->sobrenome;
    }

    public function getDataDeNascimento() {
        return $this->dataDeNascimento;
    }

}
