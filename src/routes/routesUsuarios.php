<?php
use Domain\Services\BibliotecaService;

$bibliotecaService = new BibliotecaService();
$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
$id = null;

if (preg_match('/\/usuarios\/(\d+)/', $requestUri, $matches)) {
    $id = (int)$matches[1];
}

if ($method === 'GET' && strpos($requestUri, '/usuarios') !== false) {
    $usuarios = $bibliotecaService->listarUsuarios();
    echo json_encode($usuarios);
    exit;
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (strpos($requestUri, '/usuarios') !== false) {

        if (isset($data['nome'], $data['sobrenome'], $data['data_de_nascimento'], $data['matricula'])) {
            $bibliotecaService->addUsuario($data['nome'], $data['sobrenome'], $data['data_de_nascimento'], $data['matricula']);
            http_response_code(201);
            echo json_encode(["message" => "Usuário criado com sucesso"]);

        } else {
            http_response_code(400);
            echo json_encode(["error" => "Dados incompletos para criar o usuário."]);
        }

    } else {
        http_response_code(404);
        echo json_encode(["error" => "Rota não encontrada."]);
    }

    exit;
}

if ($method === 'PUT' && $id !== null) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (strpos($requestUri, '/usuarios') !== false) {
        if (isset( $data['nome'], $data['sobrenome'], $data['data_de_nascimento'], $data['matricula'])) {

            if ($bibliotecaService->updateUsuario($id, $data['nome'], $data['sobrenome'], $data['data_de_nascimento'], $data['matricula'])) {
                http_response_code(200);
                echo json_encode(["message" => "Usuário atualizado com sucesso"]);

            } else {
                http_response_code(404);
                echo json_encode(["error" => "Usuário não encontrado"]);
            }

        } else {
            http_response_code(400);
            echo json_encode(["error" => "Dados incompletos para atualizar o usuário."]);
        }

    } else {
        http_response_code(404);
        echo json_encode(["error" => "Rota não encontrada."]);
    }

    exit;
}

if ($method === 'DELETE' && $id !== null) {
    if (strpos($requestUri, '/usuarios') !== false) {

        if ($bibliotecaService->deleteUsuario($id)) {
            http_response_code(200);
            echo json_encode(["message" => "Usuário excluído com sucesso"]);

        } else {
            http_response_code(404);
            echo json_encode(["error" => "Usuário não encontrado"]);

        }

    } else {
        http_response_code(404);
        echo json_encode(["error" => "Rota não encontrada."]);
    }

    exit;
}