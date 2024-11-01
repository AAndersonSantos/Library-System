<?php

namespace Tests;

use Domain\Repositories\LivroRepository;
use Domain\Models\Livro;
use PDO;
use PHPUnit\Framework\TestCase;

class LivroRepositoryTest extends TestCase {
    private $connection;
    private $livroRepository;

    protected function setUp(): void {
        $this->connection = $this->createMock(PDO::class);
        $this->livroRepository = new LivroRepository($this->connection);
    }

    public function testAddLivro() {

        $titulo = "Título do Livro";
        $autor = "Autor do Livro";
        $isbn = "1234567890123";

        $stmtMock = $this->createMock(\PDOStatement::class);
        $this->connection->method('prepare')->willReturn($stmtMock);

        $stmtMock->expects($this->exactly(3))
            ->method('bindValue')
            ->with(
                $this->logicalOr(
                    $this->equalTo(':titulo'),
                    $this->equalTo(':autor'),
                    $this->equalTo(':isbn')
                )
            );
        
        $stmtMock->expects($this->once())
            ->method('execute')
            ->willReturn(true);
        
        $this->livroRepository->addLivro($titulo, $autor, $isbn);

        $this->assertTrue(true);

    }

    public function testListarLivros() {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $this->connection->expects($this->once())
            ->method('query')
            ->willReturn($stmtMock);
        
        $stmtMock->expects($this->once())
            ->method('fetchAll')
            ->with(\PDO::FETCH_ASSOC)
            ->willReturn([
                ['titulo' => 'Livro 1', 'autor' => 'Autor 1', 'isbn' => '1234567890123'],
                ['titulo' => 'Livro 2', 'autor' => 'Autor 2', 'isbn' => '9876543210987']
            ]);
        
        $livros = $this->livroRepository->listarLivros();
        
        $this->assertCount(2, $livros);
        $this->assertEquals('Livro 1', $livros[0]['titulo']);
    }

    public function testDelete() {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $this->connection->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);
        
        $stmtMock->expects($this->once())
            ->method('bindValue')
            ->with($this->equalTo(':id'), $this->anything(), \PDO::PARAM_INT);
        
        $stmtMock->expects($this->once())
            ->method('execute')
            ->willReturn(true);
        
        $id = 1;
        $result = $this->livroRepository->delete($id);
        
        $this->assertTrue($result);
    }

    public function testUpdate() {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $this->connection->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);
        
        $stmtMock->expects($this->exactly(4))
            ->method('bindValue')
            ->with(
                $this->logicalOr(
                    $this->equalTo(':titulo'),
                    $this->equalTo(':autor'),
                    $this->equalTo(':isbn'),
                    $this->equalTo(':id')
                )
            );
        
        $stmtMock->expects($this->once())
            ->method('execute')
            ->willReturn(true);
        
        $id = 1;
        $titulo = "Título Atualizado";
        $autor = "Autor Atualizado";
        $isbn = "1234567890123";
        $result = $this->livroRepository->update($id, $titulo, $autor, $isbn);
        
        $this->assertTrue($result);
    }
}
