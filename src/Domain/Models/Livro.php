<?php
namespace Domain\Models;

class Livro {
    private $titulo;
    private $autor;
    private $isbn;

    public function __construct($titulo, $autor, $isbn) {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->isbn = $isbn;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getAutor() {
        return $this->autor;
    }

    public function getIsbn() {
        return $this->isbn;
    }
}
