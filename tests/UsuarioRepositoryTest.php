<?php

namespace Tests;

use Domain\Repositories\UsuarioRepository;
use Domain\Models\Usuario;
use PHPUnit\Framework\TestCase;
use PDO;
use PDOStatement;

class UsuarioRepositoryTest extends TestCase {
    private $connection;
    private $usuarioRepository;

    protected function setUp(): void {
        $this->connection = $this->createMock(PDO::class);
        $this->usuarioRepository = new UsuarioRepository($this->connection);
    }

    public function testAddUsuario() {
        $usuario = new Usuario("John", "Doe", "1990-01-01", "12345");

        $stmtMock = $this->createMock(PDOStatement::class);
        $this->connection->method('prepare')->willReturn($stmtMock);

        $stmtMock->expects($this->exactly(4))
                  ->method('bindValue')
                  ->with($this->logicalOr(
                      $this->equalTo(':nome'),
                      $this->equalTo(':sobrenome'),
                      $this->equalTo(':data_de_nascimento'),
                      $this->equalTo(':matricula')
                  ));

        $stmtMock->expects($this->once())
                  ->method('execute')
                  ->willReturn(true); 

        $this->usuarioRepository->add($usuario);

        $this->assertTrue(true);
    }
}
