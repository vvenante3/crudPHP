<?php

    require_once 'models/UserModels.php';

    Class AuthController
    {
        private $model;

        public function __construct()
        {
            $this->model = new UserModel();
            session_start();
        }

        public function index(){
            $method = $_SERVER['REQUEST_METHOD'];

            if ($method == 'POST'){
                $json = file_get_contents('php://input');
                $data = json_decode($json, true);

                if(!isset($data['email'], $data['senha'])){
                    http_response_code(400);
                    echo json_encode(['erro' => 'E-mail e senha obrigatórios!']);
                    return;
                }

                $usuario = $this->model->findByEmail($data['email']);

                if(!$usuario || !password_verify($data['senha'], $usuario['senha'])) {
                    http_response_code(401);
                    echo json_encode(['erro' => 'Credenciais inválidas']);
                    return;
                }

                $_SESSION['usuario'] = [
                    'id'        => $usuario['id'],
                    'nome'      => $usuario['nome'],
                    'email'     => $usuario['email'],
                    'perfil'    => $usuario['perfil']
                ];

                echo json_encode(['mensagem' => 'Login bem-sucedido']);

            }

            else if ($method == 'GET'){
                if (isset($_SESSION['usuario'])){
                    echo json_encode($_SESSION['usuario']);
                } else {
                    http_response_code(401);
                    echo json_encode(['erro' => 'Usuário não autenticado']);
                }
            }

            else if ($method === 'DELETE'){
                session_destroy();
                echo json_encode(['mensagem' => 'Logout realizado com sucesso']);
            }

            else {
                http_response_code(405);
                echo json_encode(['erro' => 'Método não suportado']);
            }
        }
    }
    
?>