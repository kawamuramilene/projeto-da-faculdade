<?php

$host = 'localhost'; 
$user = 'root'; 
$pass = ''; 
$dbname = 'contatos'; 


$conn = new mysqli($host, $user, $pass, $dbname);


if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $nome = htmlspecialchars(trim($_POST['nome']));
    $email = htmlspecialchars(trim($_POST['email']));
    $assunto = htmlspecialchars(trim($_POST['assunto']));
    $mensagem = htmlspecialchars(trim($_POST['mensagem']));

    // Verificação básica
    if (empty($nome) || empty($email) || empty($assunto) || empty($mensagem)) {
        die("Todos os campos são obrigatórios.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("E-mail inválido.");
    }


    $nome = $conn->real_escape_string($nome);
    $email = $conn->real_escape_string($email);
    $assunto = $conn->real_escape_string($assunto);
    $mensagem = $conn->real_escape_string($mensagem);


    $sql = "INSERT INTO formulario_contato (nome, email, assunto, mensagem)
            VALUES ('$nome', '$email', '$assunto', '$mensagem')";

    if ($conn->query($sql) === TRUE) {
        echo "Mensagem enviada com sucesso!";
    } else {
        echo "Erro ao enviar mensagem: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Acesso inválido.";
}
?>
