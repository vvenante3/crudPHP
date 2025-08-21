<?php

require_once 'models/ContatoModel.php';

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
        if(!$this->checkLogout()) {
            header('Location: ?url=auth');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_GET['edit'])) {
            $this->model->create($_POST);
            header('Location: ?url=contato');
            exit;
        }

        if(isset($_GET['delete']) && $this->checkAdmin()) {
            $this->model->delete($_GET['delete']);
            header('Location: ?url=contato');
            exit;
        }

        if(isset($_GET['edit']) && $this->checkAdmin()) {
            $id = $_GET['edit'];
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->model->update($id, $_POST);
                header('Location: ?url=contato');
                exit;
            }
            $contatoEditar = $this->model->getById($id);
        }

        $contatos = $this->model->getAll();
        require_once 'views/home.php';

    }
}

?>