<?php

    require_once 'models/UserModels.php';

    class AuthController
    {
        private $model;

        public function __construct()
        {
            $this->model = new UserModel();
        }

        public function index()
        {
            if(isset($_GET['logout'])) {
                session_destroy();
                header('Location: ?url=auth');
                exit;
            }

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = $_POST['email'];
                $senha = $_POST['senha'];

                $user = $this->model->login($email, $senha);
                if($user) {
                    $_SESSION['usuario'] = $user;
                    header('Location: ?url=contato');
                    exit;
                } else {
                    $erro = 'Credenciais inválidas';
                }
            }

            require_once 'views/login.php';

        }
    }

?>