<?php

    require_once 'core/Database.php';

    class UserModel
    {
        private $db;
        private $table = 'users';

        public function __construct()
        {
            $this->db = Database::getInstance();
        }

        public function findByEmail($email)
        {
            $sql = "SELECT id, nome, email, senha, perfil FROM {$this->table} WHERE email = :email LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['email' => $email]);
            return $stmt->fetch();
        }

        public function login($email, $senha)
        {
            $user = $this->findByEmail($email);
            if (!$user) return false;

            if (!password_verify($senha, $user['senha'])) {
                return false;
            }

            return [
                'id'        => (int)$user['id'],
                'nome'      => $user['nome'],
                'email'     => $user['email'],
                'perfil'    => $user['perfil'],
            ];

        }

    }

?>