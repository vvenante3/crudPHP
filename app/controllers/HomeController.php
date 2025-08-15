<?php

require_once 'models/ContatoModel.php';

class HomeController
{
    public function index()
    {
        $model      = new ContatoModel();
        $contatos   = $model->getAll();

        require 'views/home.php';
    }
}