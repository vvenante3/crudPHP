<?php

    require_once 'core/Database.php';

    class UserModel
    {
        private $db;

        public function __construct()
        {
            $this->db = Database::getInstance();
        }

        public function findByEmail($email)
        {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            return $stmt->fetch();
        }
    }

?>