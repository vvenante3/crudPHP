<?php

require_once 'core/Database.php';

class ContatoModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Irá obter todos os contatos
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM contatos ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    // Irá obter através do ID de contatos
    public function getById($id)
    {
        $stmt = $this->db->query("SELECT * FROM contatos WHERE id = :id");
    }

    // Irá inserir um novo contato
    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO contatos (nome, sobrenome, telefone, email)
            VALUES (:nome, :sobrenome, :telefone, :email)
        ");
    
        return $stmt->execute([
            'nome'      =>  $data['nome'],
            'sobrenome' =>  $data['sobrenome'],
            'telefone'  =>  $data['telefone'],
            'email'     =>  $data['email'],    
        ]);
    }

    // Irá atualizar os contatos já existentes
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE CONTATOS SET
                nome        = :nome,
                sobrenome   = :sobrenome,
                telefone    = :telefone,
                email       = :email
            WHERE id = :id 
        ");

        return $stmt->execute([
            'id'        => $id,
            'nome'      => $data['nome'],
            'sobrenome' => $data['sobrenome'],
            'telefone'  => $data['telefone'],
            'email'     => $data['email'],
        ]);
    }

    // Irá excluir o contato
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM contatos WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}