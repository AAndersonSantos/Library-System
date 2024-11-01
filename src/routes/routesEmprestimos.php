<?php

use Domain\Services\BibliotecaService;

$bibliotecaService = new BibliotecaService();
$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

if ($method === 'POST' && strpos($requestUri, '/emprestimos') !== false) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['livroId'], $data['usuarioId'])) {
        try {
            $bibliotecaService->registrarEmprestimo($data['livroId'], $data['usuarioId']);
            http_response_code(201);
            echo json_encode(["message" => "Empréstimo registrado com sucesso"]);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => "Erro ao registrar empréstimo: " . $e->getMessage()]);
        }

    } else {
        http_response_code(400);
        echo json_encode(["error" => "Dados incompletos para registrar o empréstimo."]);
    }

    exit;
}

if ($method === 'GET' && strpos($requestUri, '/emprestimos') !== false) {

    try {
        $emprestimos = $bibliotecaService->listarEmprestimos();
        echo json_encode($emprestimos);

    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao listar empréstimos: " . $e->getMessage()]);
    }
    
    exit;
}

http_response_code(404);
echo json_encode(["error" => "Rota não encontrada."]);
