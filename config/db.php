<?php
class Database
{
    private $host = "localhost";
    private $db_name = "gestao_financeira";
    private $username = "root";
    private $password = "123";
    public $conn;

    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Erro de conexão: " . $e->getMessage());
        }
        return $this->conn;
    }

    public function close()
    {
        $this->conn = null;
    }
}
