<?php

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $host   = getenv('DB_HOST') ?: 'db';
        $dbname = getenv('DB_NAME') ?: 'projeto';
        $user   = getenv('DB_USER') ?: 'user';
        $pass   = getenv('DB_PASS') ?: 'user123';
    
    try {
        $this->pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
            $user,
            $pass
        );

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e){
            die ("Erro de conexão com o banco: " .$e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }

        return self::$instance->pdo;
    }

}