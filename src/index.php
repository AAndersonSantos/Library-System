<?php
ob_start();

require_once __DIR__ . '/Domain/Models/Emprestimo.php';
require_once __DIR__ . '/Domain/Models/Livro.php';
require_once __DIR__ . '/Domain/Models/Pessoa.php';
require_once __DIR__ . '/Domain/Models/Usuario.php';
require_once __DIR__ . '/Domain/Repositories/LivroRepository.php';
require_once __DIR__ . '/Domain/Repositories/UsuarioRepository.php';
require_once __DIR__ . '/Domain/Repositories/EmprestimoRepository.php';
require_once __DIR__ . '/Domain/Services/BibliotecaService.php';
require_once __DIR__ . '/Infrastructure/Database/Database.php';

use Domain\Services\BibliotecaService;
use Infrastructure\Database\Database;

$bibliotecaService = new BibliotecaService();
$database = new Database();

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/') {
    echo json_encode(["message" => "Bem-vindo a API da Biblioteca!"]);

} elseif (preg_match('/\/livros(\/(\d+))?/', $requestUri)) {
    require_once __DIR__ . '/routes/routesLivros.php';

} elseif (preg_match('/\/usuarios(\/(\d+))?/', $requestUri)) {
    require_once __DIR__ . '/routes/routesUsuarios.php';

} elseif (preg_match('/\/emprestimos(\/(\d+))?/', $requestUri)) {
    require_once __DIR__ . '/routes/routesEmprestimos.php';

} else {
    http_response_code(404);
    echo json_encode(["error" => "Rota não encontrada."]);
}

ob_end_flush();
