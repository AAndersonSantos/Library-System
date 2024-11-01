<?php

namespace Tests;

use Domain\Repositories\EmprestimoRepository;
use Domain\Models\Emprestimo;
use PDO;
use PHPUnit\Framework\TestCase;

class EmprestimoRepositoryTest extends TestCase {
    private $connection;
    private $emprestimoRepository;

    protected function setUp(): void {
        $this->connection = $this->createMock(PDO::class);
        $this->emprestimoRepository = new EmprestimoRepository($this->connection);
    }

    public function testSalvarEmprestimo() {
        $emprestimoMock = $this->createMock(Emprestimo::class);
        $emprestimoMock->method('getUsuarioId')->willReturn(1);
        $emprestimoMock->method('getLivroId')->willReturn(1);
        $emprestimoMock->method('getDataEmprestimo')->willReturn(new \DateTime('2023-01-01 10:00:00'));

        $stmtMock = $this->createMock(\PDOStatement::class);
        $updateStmtMock = $this->createMock(\PDOStatement::class);

        $this->connection->expects($this->exactly(2))
            ->method('prepare')
            ->will($this->onConsecutiveCalls($stmtMock, $updateStmtMock));

        $stmtMock->expects($this->once())
            ->method('execute')
            ->with([
                'usuario_id' => 1,
                'livro_id' => 1,
                'data_emprestimo' => '2023-01-01 10:00:00'
            ])
            ->willReturn(true);

        $updateStmtMock->expects($this->once())
            ->method('execute')
            ->with(['livro_id' => 1])
            ->willReturn(true);

        $this->emprestimoRepository->salvarEmprestimo($emprestimoMock);
    }
}
