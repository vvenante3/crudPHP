<?php

require_once 'models/ContatoModel.php';

Class ContatoController
{
    private $model;

    public function __construct()
    {
        $this->model = new ContatoModel();
    }

    public function index()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                $this->handleGet();
                break;

            case 'POST':
                $this->handlePost();
                break;

            case 'PUT':
                $this->handlePut();
                break;

            case 'DELETE':
                $this->handleDelete();
                break;

            default:
                http_response_code(405);
                echo json_encode(['erro' => 'Método não permitido']);
        }
    }

    private function handleGet()
    {
        header('Content-Type: application/json');

        $id = $_GET['id'] ?? null;

        if($id){
            $contato = $this->model->getById($id);

            if($contato){
                echo json_encode($contato);
            } else{
                http_response_code(404);
                echo json_encode(['erro' => 'Contato não encontrado']);
            }
        } else{
            $contatos = $this->model->getAll();
            echo json_encode($contatos);
        }
    }

    private function handlePost()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        if(
            isset($data['nome']) &&
            isset($data['sobrenome']) &&
            isset($data['telefone']) &&
            isset($data['email'])
        ) {
            $sucesso = $this->model->create($data);

            if($sucesso){
                http_response_code(201);
                echo json_encode(['mensagem' => 'Contato criado com sucesso']);
            } else{
                http_response_code(500);
                echo json_encode(['erro' => 'Erro ao criar contato']);
            } 
        } else{
            http_response_code(480);
            echo json_encode(['erro' => 'Dados inválidos']);
        }
    }

    private function handlePut()
    {
        header('Content-Type: application/json');

        $id = $_GET['id'] ?? null;
        $data = json_decode(file_get_contents('php://input'), true);

        if(!$id){
            http_response_code(400);
            echo json_encode(['erro' => 'ID não encontrado']);
            return;
        }

        $sucesso = $this->model->update($id, $data);

        if($sucesso){
            echo json_encode(['mensagem' => 'Contato atualizado com sucesso']);
        } else{
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao atualizar contato']);
        }
    }

    private function handleDelete()
    {
        header('Content-Type: application/json');
        $id = $_GET['id'] ?? null;

        if(!$id){
            http_response_code(400);
            echo json_encode(['erro' => 'ID não encontrado']);
            return;
        }

        $sucesso = $this->model->delete($id);

        if($sucesso){
            http_response_code(200);
            echo json_encode(['mensagem' => 'Contato excluído com sucesso']);
        } else{
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao excluir contato']);
        }
    }
}

?>