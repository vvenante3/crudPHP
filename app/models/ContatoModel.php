<?php

require_once 'core/Database.php';

class ContatoModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }
}