<?php
require_once 'model/cadastro.php';

class CadastroController {
    private $cadastro;

    public function __construct() {
        $this->cadastro = new Cadastro();
    }

    public function create($nome, $email, $senha) {
        if ($this->cadastro->create($nome, $email, $senha)) {
            header('Location: view/cadastroTela.php?message=success'); //arrumar 
            exit;
        } else {
            header("Location: ../view/cadastroTela.php?message=Erro ao cadastrar dados"); //arrumar 
        }
    }
}
?>