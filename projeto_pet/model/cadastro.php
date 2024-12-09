<?php
require_once 'conexao.php';

class Cadastro {
    private $conn;

    public function __construct() {
        $conexao = new Conexao();
        $this->conn = $conexao->getConnection();
    }

    public function create($nome, $email, $senha) {
        $query = "INSERT INTO cadastro (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        return $this->conn->query($query);
    }
}
?>