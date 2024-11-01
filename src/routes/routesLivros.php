<?php
use Domain\Services\BibliotecaService;

$bibliotecaService = new BibliotecaService();
$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
$id = null;

if (preg_match('/\/livros\/(\d+)/', $requestUri, $matches)) {
    $id = (int)$matches[1];
}

if ($method === 'GET' && strpos($requestUri, '/livros') !== false) {
    $livros = $bibliotecaService->listarLivros();
    echo json_encode($livros);
    exit;
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (strpos($requestUri, '/livros') !== false) {

        if (isset($data['titulo'], $data['autor'], $data['isbn'])) {
            $bibliotecaService->addLivro($data['titulo'], $data['autor'], $data['isbn']);
            http_response_code(201);
            echo json_encode(["message" => "Livro criado com sucesso"]);

        } else {
            http_response_code(400);
            echo json_encode(["error" => "Dados incompletos para criar o livro."]);
        }

    } else {
        http_response_code(404);
        echo json_encode(["error" => "Rota não encontrada."]);
    }

    exit;
}

if ($method === 'PUT' && $id !== null) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (strpos($requestUri, '/livros') !== false) {

        if (isset($data['titulo'], $data['autor'], $data['isbn'])) {

            if ($bibliotecaService->updateLivro($id, $data['titulo'], $data['autor'], $data['isbn'])) {
                http_response_code(200);
                echo json_encode(["message" => "Livro atualizado com sucesso"]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Livro não encontrado"]);
            }

        } else {
            http_response_code(400);
            echo json_encode(["error" => "Dados incompletos para atualizar o livro."]);
        }

    } else {
        http_response_code(404);
        echo json_encode(["error" => "Rota não encontrada."]);
    }

    exit;
}

if ($method === 'DELETE' && $id !== null) {

    if (strpos($requestUri, '/livros') !== false) {
        if ($bibliotecaService->deleteLivro($id)) {
            http_response_code(200);
            echo json_encode(["message" => "Livro excluído com sucesso"]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Livro não encontrado"]);
        }

    } else {
        http_response_code(404);
        echo json_encode(["error" => "Rota não encontrada."]);
    }

    exit;
}