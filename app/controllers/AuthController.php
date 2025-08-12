<?php

    require_once 'models/UserModels.php';

    Class AuthController
    {
        private $model;

        public function __construct()
        {
            $this->model = new UserModel();
        }

        public function checkAdmin()
        {
            return isset($_SESSION['usuario']) && $_SESSION['usuario']['perfil'] === 'admin';
        }

        public function checkLogged()
        {
            return isset($_SESSION['usuario']);
        }

        public function index()
        {
            if(!$this->checkLogged()) {
                http_response_code(401);
                echo json_encode(['erro' => 'Usuário não autorizado']);
                return;
            }

            $method = $_SERVER['REQUEST_METHOD'];

            // refazer daqui pra baixo

            // method GET

            // method POST

            // method PUT

            // method DELETE

        }
    }
    
?>