<?php

require_once 'models/ContatoModel.php';
session_start();

Class ContatoController
{
    private $model;

    public function __construct()
    {
        $this->model = new ContatoModel();
    }

    private function checkAdmin(){
        return isset($_SESSION['usuario']) && $_SESSION['usuario']['perfil'] === 'admin';
    }

    private function checkLogout(){
        return isset($_SESSION['usuario']);
    }

    public function index()
    {
        // verificar autenticação 
        if (!$this->checkLogout()){
            http_response_code(401);
            echo json_encode(['erro' => 'Usuário não autenticado']);
            return;
        }

        $method = $_SERVER['REQUEST_METHOD'];

        // method GET
        if ($method === 'GET'){
            $contatos = $this->model->getAll();
            header('Content-Type: application/json');
            echo json_encode($contatos);
            return;
        }

        if ($method === 'POST'){
            $data = $_POST;
            if (empty($data)){
                $json = file_get_contents('php://input');
                $data = json_decode($json, true);
            }

            if(!isset($data['nome'], $data['email'])) {
                http_response_code(400);
                echo json_encode(['erro' => 'Nome e email são obrigatórios']);
                return;
            }

            $this->model->create($data);
            http_response_code(201);
            echo json_encode(['mensagem' => 'Contato criado com sucesso']);
            return;   
        }

        if ($method === 'PUT') {
            if (!$this->checkAdmin()) {
                http_response_code(403);
                echo json_encode(['erro' => 'Acesso negado: somente admins pode atualizar']);
                return;
            }

            parse_str(file_get_contents('php://input'), $putVars);

            if (!isset($putVars['id'])) {
                http_response_code(400);
                echo json_encode(['erro' => 'ID do contato é obrigatório']);
                return;
            }

            $id = $putVars['id'];

            $this->model->update($id, $putVars);
            echo json_encode(['mensagem' => 'Contato atualizado com sucesso']);
            return;

        }

        if ($method === 'DELETE') {
            if (!$this->checkAdmin()) {
                http_response_code(403);
                echo json_encode(['erro' => 'Acesso negado: somente admins podem deletar']);
                return;
            }

            parse_str(file_get_contents('php://input'), $delVars);

            if (!isset($delVars['id'])) {
                http_response_code(400);
                echo json_encode(['erro' => 'ID do contato é obrigatório']);
                return;
            }

            $id = $delVars['id'];

            $this->model->delete($id);
            echo json_encode(['mensagem' => 'Contato deletado com sucesso']);
            return;
        }

        http_response_code(405);
        echo json_encode(['erro' => 'Método não suportado']);
    }
}

?>