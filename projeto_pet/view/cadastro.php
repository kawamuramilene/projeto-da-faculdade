<?php
include("conexao.php");
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "INSERT INTO loja_indie (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
if (mysqli_query($conexao, $sql)) {
    echo "Usuário cadastrado com sucesso";
} else {
    echo "Erro: " . $conexao->connect_error;
}

mysqli_close($conexao);

?>